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
    // Yes, they indeed are! A DatabaseConnection is only there to forward data, not processing it. This is why we got this class.
    public function addBook($book) {
        $data['file_name'] = $book->original_name . '.' . $book->original_extension;
        $data['uuid'] = $book->uuid;
        $data['cover_image'] = $book->metadata->cover_image;
        $data['title'] = $book->metadata->title;
        $data['author'] = $book->metadata->author;
        $data['description'] = $book->metadata->description;
        $data['language'] = $book->metadata->language;
        $data['identifier'] = $book->metadata->identifier;
        return $this->database_connection->insertBook($data);
    }

    public function deleteBook($book) {
        $id = $this->database_connection->getBook('uuid', $book->uuid, true);
        $this->database_connection->deleteBook($id);
        DataIo\FileManager::deleteBook($book);
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


    public function getBook($field, $query, $exact = false) {
        return $this->database_connection->getBook($field, $query, $exact);
    }

    public function listBooks() {
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
