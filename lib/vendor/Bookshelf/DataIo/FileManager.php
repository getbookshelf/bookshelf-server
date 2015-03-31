<?php

namespace Bookshelf\DataIo;

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
