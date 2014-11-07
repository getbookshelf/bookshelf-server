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
        $this->config = new Configuration(true, $this->database_connection);
    }

    // TODO: Are these methods needed in here? They just forward to the DB con methods...
    public function addBook($book) {
        return $this->database_connection->insertBook($book);
    }

    public function getBook($file_name, $file_hash) {
        // TODO: Doesn't work anymore
        //$result = $this->database_connection->getBook(array('file_name' => $file_name, 'file_hash' => $file_hash));
        //return (empty($result[0]) ? -1 : $result[0]);
    }

    public function listBooks() {
        // TODO: Doesn't work anymore
        //$result = $this->database_connection->getBook(null, array('file_name', 'file_hash', 'title'));
        //return (empty($result) ? -1 : $result);
    }
}
