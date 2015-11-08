<?php

namespace Bookshelf\DataIo;

use Bookshelf\Core\Application;
use Bookshelf\Core\Configuration;
use Bookshelf\Core\LibraryManager;
use Bookshelf\DataType\Book;
use Bookshelf\Utility\ErrorHandler;
use Bookshelf\Utility\ErrorLevel;

class FileManager {
    public function __construct() {
        $this->config = new Configuration();
    }

    // $files_array is the PHP $_FILES
    public function uploadBook($files_array) {
        $uuid = $this->generateUuid();

        // path (including filename) where the uploaded book will be stored on the server
        $file = realpath($this->config->getLibraryDir()) . '/' . $uuid . pathinfo(basename($files_array['file']['name']), PATHINFO_EXTENSION);

        if(!move_uploaded_file($files_array['file']['tmp_name'], $file)) {
            ErrorHandler::throwError('Could not upload file.', ErrorLevel::ERROR);
            return -1;
        }

        $result = new Book(-1, $uuid, pathinfo(basename($files_array['file']['name']), PATHINFO_FILENAME), pathinfo(basename($files_array['file']['name']), PATHINFO_EXTENSION));

        $library_manager = new LibraryManager();
        return $library_manager->addBook($result);
    }

    public static function deleteBook($id) {
        $config = new Configuration();
        $db_con = new DatabaseConnection();

        $book = $db_con->getBookById($id);
        unlink(realpath($config->getLibraryDir()) . '/' . $book['uuid'] . pathinfo($book['file_name'], PATHINFO_EXTENSION));
    }

    // returns string (file path) or false if there was an error
    public function storeTempFile($file_data, $filename, $context = 'general') {
        if(!is_dir(Application::TMP_DIR . '/' . $context)) {
            mkdir(Application::TMP_DIR . '/' . $context, 0777, true);
        }
        $full_path = Application::TMP_DIR . '/' . $context . '/' . $filename;
        $status = file_put_contents($full_path, $file_data);

        return $status ? $full_path : false;
    }

    public function cleanTempContext($context) {
        $dir = Application::TMP_DIR . '/' . $context;
        $this->sureRemoveDir($dir, true);
    }

    // returns bool
    public function unzipFile($zip_path, $extract_to) {
        $zip = new \ZipArchive();
        if($zip->open($zip_path)) {
            $zip->extractTo($extract_to);
            $zip->close();
            return true;
        }
        else { return false; }
    }

    // taken from https://secure.php.net/manual/en/function.unlink.php#79940
    private function sureRemoveDir($dir, $alsoDeleteDir) {
        if(!$dh = @opendir($dir)) return;
        while (false !== ($obj = readdir($dh))) {
            if($obj == '.' || $obj == '..') continue;
            if(!@unlink($dir . '/' . $obj)) $this->sureRemoveDir($dir . '/' . $obj, true);
        }

        closedir($dh);
        if ($alsoDeleteDir) @rmdir($dir);
    }

    private function generateUuid(){
        // see http://rogerstringer.com/2013/11/15/generate-uuids-php/
        $uuid = sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0x0fff) | 0x4000,
            mt_rand(0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $possible_duplicate = glob($this->config->getLibraryDir() . $uuid . '.*');

        return count($possible_duplicate) > 0 ? $this->generateUuid() : $uuid;
    }
}
