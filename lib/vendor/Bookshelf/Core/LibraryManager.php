<?php

namespace Bookshelf\Core;

use Bookshelf\DataType\BookMetadata;
use Bookshelf\DataIo\DatabaseConnection;
use Bookshelf\DataIo;

class LibraryManager {
    private $database_connection;
    
    function __construct() {
        $this->database_connection = new DatabaseConnection();
    }

    function addBook($filename, $metadata = null) {
        // unfortunately, there is no other way to set a parameter default value to an expression: http://stackoverflow.com/a/5859401
        if($metadata === null) {
            $metadata = new BookMetadata();
        }

        require Application::LIB_DIR . 'config.php';

        $file_hash = DataIo\FileManager::hash($LIBRARY_DIR . '/' . $filename);
        $args = array('file_name' => "'" . $filename . "'",
                      'file_hash' => "'" . $file_hash . "'");
        
        $args .= $metadata->getArray();
        foreach($args as $key => $value) {
            $args[$key] = "'" . $value . "'";
        }
        
        $this->database_connection->insertLibraryData($args);
    }
}