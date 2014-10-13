<?php

namespace Bookshelf\DataIo;

use Bookshelf\Core\Application;
use Bookshelf\Utility\ErrorHandler;
use Bookshelf\Utility\ErrorLevel;

class FileManager {
    // TODO: Do we want to store the extension separately, in both vars or only in one of them?
    // Currently, it is only stored in $file_name, e.g.:
    // $file_name = 'mybook.pdf'; $uuid = '550e8400e29b11d4aa716446655440000';
    public $file_name = '';
    public $uuid = '';

    // TODO: this should be obsolete and not needed anymore
    public function hash($file_path) {
        $file_text = file_get_contents($file_path, false, null, -1, 1048576); // Read only 1 MB
        return hash('sha256', $file_text);
    }

    public function uploadBook() {
        require Application::ROOT_DIR . 'config.php';

        // generate UUID,  see http://rogerstringer.com/2013/11/15/generate-uuids-php/
        $uuid = sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0x0fff) | 0x4000,
            mt_rand(0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
        $file = $LIBRARY_DIR . $uuid . pathinfo(basename($_FILES['file']['name']), PATHINFO_EXTENSION);

        if(!move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
            ErrorHandler::throwError('Could not upload file.', ErrorLevel::ERROR);
            return;
        }

        $this->uuid = $uuid;
        $this->file_name = basename($_FILES['file']['name']);
    }

    public function getQueryString() {
        // TODO: Implement better algorithm to get query string
        $query_string = pathinfo($this->file_name, PATHINFO_FILENAME); // filename without extension
        $strings_to_replace = array('-', '_', '.', ',', ';', ':', '/', '|', '+');
        $query_string = str_replace($strings_to_replace, ' ', $query_string);

        return $query_string;
    }
}