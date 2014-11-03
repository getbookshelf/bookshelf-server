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

    public function addBook($book) {
        return $this->database_connection->insertLibraryData($book);
    }
    
    public function getBook($file_name, $file_hash) {
        // TODO: Doesn't work anymore
        $result = $this->database_connection->selectLibraryData(array('file_name' => $file_name, 
                                                                      'file_hash' => $file_hash));
        return (empty($result[0]) ? -1 : $result[0]);
    }
    
    public function listBooks() {
        // TODO: Doesn't work anymore
        $result = $this->database_connection->selectLibraryData(null, array('file_name', 'file_hash', 'title'));
        return (empty($result) ? -1 : $result);
    }
}