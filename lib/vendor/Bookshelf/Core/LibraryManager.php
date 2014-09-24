<?php

namespace Bookshelf\Core;

use Bookshelf\DataType\BookMetadata;
use Bookshelf\DataIo\DatabaseConnection;
use Bookshelf\DataIo;

class LibraryManager {
    require Application::ROOT_DIR . 'config.php';
    
    private $database_connection;
    
    function __construct() {
        $database_connection = new DatabaseConnection();
    }
    
    function addBook($filename, $metadata = new BookMetadata()){
        $file_hash = DataIo\FileManager::hash($LIBRARY_DIR . '/' . $filename);
        $args = array('file_name' => "'" . $filename . "'",
                      'file_hash' => "'" . $file_hash . "'");
        
        $args .= $metadata->getArray();
        foreach($args as $key => $value) {
            $args[$key] = "'" . $value . "'";
        }
        
        $database_connection->insertLibraryData($args)
    }
}