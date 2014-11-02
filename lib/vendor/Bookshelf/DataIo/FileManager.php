<?php

namespace Bookshelf\DataIo;

use Bookshelf\Core\Configuration;
use Bookshelf\Core\LibraryManager;
use Bookshelf\DataType\Book;
use Bookshelf\Utility\ErrorHandler;
use Bookshelf\Utility\ErrorLevel;

class FileManager {
    // $files_array is the PHP $_FILES
    public function uploadBook($files_array) {
        $config = new Configuration();

        $result = new Book();
        $uuid = $this->generateUuid();

        // path (including filename) where the uploaded book will be stored on the server
        $file = realpath($config->getLibraryDir()) . '/' . $uuid . pathinfo(basename($files_array['file']['name']), PATHINFO_EXTENSION);

        if(!move_uploaded_file($files_array['file']['tmp_name'], $file)) {
            ErrorHandler::throwError('Could not upload file.', ErrorLevel::ERROR);
            return;
        }

        $result->uuid = $uuid;
        $result->original_name = pathinfo(basename($files_array['file']['name']), PATHINFO_FILENAME);
        $result->original_extension = pathinfo(basename($files_array['file']['name']), PATHINFO_EXTENSION);

        $library_manager = new LibraryManager();
        $library_manager->addBook($result);
        // TODO: Return book ID
    }

    private function generateUuid(){
        // see http://rogerstringer.com/2013/11/15/generate-uuids-php/
        return sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0x0fff) | 0x4000,
            mt_rand(0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}