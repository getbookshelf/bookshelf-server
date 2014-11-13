<?php

namespace Bookshelf\Core;

use Bookshelf\DataType\Book;
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

    public function getBookById($id){
        $data = $this->database_connection->getBookById($id);
        $original_name = pathinfo($data['file_name'], PATHINFO_FILENAME);
        $original_extension = pathinfo($data['file_name'], PATHINFO_EXTENSION);

        $metadata = new BookMetadata();
        $metadata->cover_image = $data['cover_image'];
        $metadata->title = $data['title'];
        $metadata->author = $data['author'];
        $metadata->description = $data['description'];
        $metadata->language = $data['language'];
        $metadata->identifier = $data['identifier'];

        return new Book($data['uuid'], $original_name, $original_extension, $metadata);
    }


    public function getBook($field, $contains) {
        return $this->database_connection->getBook($field, $contains);
    }

    public function listBooks() {
        // TODO: Doesn't work anymore
        $data_array = $this->database_connection->dumpLibraryData();
        foreach($data_array as $data) {
            $original_name = pathinfo($data['file_name'], PATHINFO_FILENAME);
            $original_extension = pathinfo($data['file_name'], PATHINFO_EXTENSION);

            $metadata = new BookMetadata();
            $metadata->cover_image = $data['cover_image'];
            $metadata->title = $data['title'];
            $metadata->author = $data['author'];
            $metadata->description = $data['description'];
            $metadata->language = $data['language'];
            $metadata->identifier = $data['identifier'];
            $result[] = new Book($data['uuid'], $original_name, $original_extension, $metadata);
        }
        return $result;
    }
}
