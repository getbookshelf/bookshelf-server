<?php

namespace Bookshelf\Utility;

use Bookshelf\Core\Application;
use Bookshelf\DataIo\FileManager;
use Bookshelf\DataIo\NetworkConnection;

class Updater {
    public $update_necessary = false;
    public $update_possible = false;

    public $new_version_code = 0;
    public $new_version_text = '0.0.0';
    public $new_version_download = '';
    private $upgrade_download = '';
    public $legacy_notice = '';
    public $release_notice = '';

    public function __construct() {
        $this->checkForUpdate();
    }

    private function checkForUpdate() {
        $version_info = json_decode(NetworkConnection::curlRequest(Application::UPDATE_VERSION_INFO_URL), true);

        if($version_info['latest_version_code'] > Application::VERSION_CODE) {
            $this->update_necessary = true;
        }
        else {
            $this->update_necessary = false;
            return;
        }

        $this->new_version_code = $version_info['latest_version_code'];
        $this->new_version_text = $version_info['latest_version_text'];
        $this->new_version_download = $version_info['latest_download'];
        $this->release_notice = $version_info['release_notice'];

        if(Application::VERSION_CODE >= $version_info['min_required']) {
            $this->update_possible = true;
        }
        else {
            $this->update_possible = false;
            $this->legacy_notice = $version_info['legacy_notice'];
            return;
        }

        $this->upgrade_download = $version_info['upgrade_download'];
    }

    public function performUpgrade() {
        if(!($this->update_necessary && $this->update_possible)) return;

        // Ignore user aborts and allow the script to run forever
        ignore_user_abort(true);
        $original_time_limit = ini_get('max_execution_time');
        set_time_limit(0);

        $file_man = new FileManager();

        echo 'Locking application.<br>';
        Application::lockForMaintenance();

        echo 'Downloading upgrade package.<br>';
        $upgrade_file = NetworkConnection::curlRequest($this->upgrade_download);
        $file_man->cleanTempContext('upgrade_' . $this->new_version_text);
        $zip_path = $file_man->storeTempFile($upgrade_file, basename($this->upgrade_download), 'upgrade_' . $this->new_version_text);
        if($zip_path == false) {
            echo 'There was an error downloading the upgrade package. Process aborted.<br>';
            Application::unlockFromMaintenance();
            return;
        }
        echo 'Successfully downloaded upgrade package.<br>';

        echo 'Extracting upgrade package.<br>';
        if($file_man->unzipFile($zip_path, Application::ROOT_DIR) == false) {
            echo 'There was an error extracting the upgrade package. Process aborted.<br>';
            Application::unlockFromMaintenance();
            return;
        }
        echo 'Successfully extracted upgrade package.<br>';

        echo 'Applying upgrade patches.<br>';
        include_once Application::ROOT_DIR . '/upgrade_' . $this->new_version_text . '.php';
        echo 'Successfully applied upgrade patches. <br>';

        echo 'Cleaning up temp files.<br>';
        $file_man->cleanTempContext('upgrade_' . $this->new_version_text);
        unlink(Application::ROOT_DIR . '/upgrade_' . $this->new_version_text . '.php');
        echo 'Successfully cleaned up temp files.<br>';

        echo 'Unlocking application.<br>';
        Application::unlockFromMaintenance();
        echo 'Successfully unlocked application.<br>';

        echo 'Upgrade successful.<br>';

        // Reset the ini settings
        ignore_user_abort(false);
        set_time_limit($original_time_limit);
    }
}
