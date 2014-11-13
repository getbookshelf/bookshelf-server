<?php

namespace Bookshelf\DataIo;

use Bookshelf\Core\Configuration;
use Bookshelf\DataType\Book;
use Bookshelf\DataType\BookMetadata;
use Bookshelf\Utility\ErrorHandler;
use Bookshelf\Utility\ErrorLevel;

class DatabaseConnection {
    private $mysqli;
    private $config;

    public function __construct() {
        $this->config = new Configuration(false);

        $this->mysqli = new \mysqli($this->config->getDatabaseHost(), $this->config->getDatabaseUser(), $this->config->getDatabasePassword(), $this->config->getDatabaseName());

        if($this->mysqli->connect_errno) {
            ErrorHandler::throwError('Could not connect to database.', ErrorLevel::CRITICAL);
            return;
        }
    }

    public function readConfigValue($property) {
        if($result = $this->mysqli->query('SELECT value FROM config WHERE property LIKE \'' . $property .'\'')) {
            return $result->fetch_array(MYSQL_ASSOC)['value'];
        }
    }

    public function validateUser($username, $password) {
        $row = $this->mysqli->query("SELECT passwd_hash FROM users WHERE username='$username'")->fetch_array();

        return hash('sha256', $password . $this->config->getSalt()) == $row['passwd_hash'];
    }

    // should not be called directly, only use from LibraryManager::addBook
    public function insertBook($book) {
        $file_name = $book->original_name . '.' . $book->original_extension;
        $uuid = $book->uuid;
        $cover_image = $book->metadata->cover_image;
        $title = $book->metadata->title;
        $author = $book->metadata->author;
        $description = $book->metadata->description;
        $language = $book->metadata->language;
        $identifier = $book->metadata->identifier;

        $query = "INSERT INTO library (file_name, uuid, cover_image, title, author, description, language, identifier) VALUES ('{$file_name}', '{$uuid}', '{$cover_image}', '{$title}', '{$author}', '{$description}', '{$language}', '{$identifier}')";
        $this->mysqli->query($query);

        return $this->mysqli->insert_id;
    }

    // $to_update = array('property' => 'value');
    // e.g.: $to_update = array('title' => 'Some Book Title', 'author' => 'Some Author');
    public function updateBook($id, $to_update) {
        $query = 'UPDATE library SET';

        foreach($to_update as $property => $value) {
            // First item does not need a comma
            if($value === reset($to_update)) {
                $query .= " {$property} = '{$value}'";
            }
            else {
                $query .= ", {$property} = '{$value}'";
            }
        }

        $query .= " WHERE id = {$id}";

        $this->mysqli->query($query);
    }

    public function getBookById($id) {
        if($result = $this->mysqli->query("SELECT * FROM library WHERE id = {$id}")) {
            return $result->fetch_array(MYSQL_ASSOC);
        }
    }

    // TODO: Decide on how we want to query the db for books (search all columns, just some specific ones, specify by parameter...?)
    public function getBook($field, $contains) {
        if($result = $this->mysqli->query("SELECT id FROM library WHERE {$field} LIKE '%{$contains}%'")) return $result;
        return -1;
    }

    public function dumpLibraryData() {
        if($result = $this->mysqli->query("SELECT * FROM library")) return $result->fetch_assoc();
    }

    public function escape($string) {
        return $this->mysqli->real_escape_string($string);
    }
}
