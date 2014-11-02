<?php

namespace Bookshelf\DataIo;

use Bookshelf\Core\Application;
use Bookshelf\Core\Configuration;
use Bookshelf\DataType\Book;
use Bookshelf\Utility\ErrorHandler;
use Bookshelf\Utility\ErrorLevel;

class FileManager {

    public function uploadBook($files_array) {
        $config = new Configuration();

        $result = new Book();
        $uuid = $this->generateUuid();

        $file = $config->getLibraryDir() . $uuid . pathinfo(basename($files_array['file']['name']), PATHINFO_EXTENSION);

        if(!move_uploaded_file($files_array['file']['tmp_name'], $file)) {
            ErrorHandler::throwError('Could not upload file.', ErrorLevel::ERROR);
            return;
        }

        $result->uuid = $uuid;
        $result->original_name = pathinfo(basename($files_array['file']['name']), PATHINFO_FILENAME);
        $result->original_extension = pathinfo(basename($files_array['file']['name']), PATHINFO_EXTENSION);

        return $result;
    }

    private function generateUuid(){
        // generate UUID,  see http://rogerstringer.com/2013/11/15/generate-uuids-php/
        return sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0x0fff) | 0x4000,
            mt_rand(0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

}