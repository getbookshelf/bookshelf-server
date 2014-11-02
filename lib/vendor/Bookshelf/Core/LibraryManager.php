<?php

namespace Bookshelf\Core;

use Bookshelf\DataType\BookMetadata;
use Bookshelf\DataIo\DatabaseConnection;
use Bookshelf\DataIo;

class LibraryManager {
    private $database_connection;
    private $config;
    
    public function __construct() {
        $this->database_connection = new DatabaseConnection();
        // TODO: We should probably allow to pass an existing DB connection to the Configuration constructor as we have one here already
        $this->config = new Configuration();
    }

    public function addBook($file_name, $metadata = null) {
        // unfortunately, there is no other way to set a parameter default value to an expression: http://stackoverflow.com/a/5859401
        if($metadata === null) $metadata = new BookMetadata();

        $file_hash = DataIo\FileManager::hash($this->config->getLibraryDir() . '/' . $file_name);
        $args = array('file_name' => $file_name,
                      'file_hash' => $file_hash);
        
        $args .= $metadata->getArray();
        foreach($args as $key => $value) {
            $args[$key] = "'" . $value . "'";
        }
        
        $this->database_connection->insertLibraryData($args);
    }
    
    public function getBook($file_name, $file_hash) {
        $result = $this->database_connection->selectLibraryData(array('file_name' => $file_name, 
                                                                      'file_hash' => $file_hash));
        return (empty($result[0]) ? -1 : $result[0]);
    }
    
    public function listBooks() {
        $result = $this->database_connection->selectLibraryData(null, array('file_name', 'file_hash', 'title'));
        return (empty($result) ? -1 : $result);
    }
}