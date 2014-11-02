<?php

namespace Bookshelf\DataIo;

use Bookshelf\Core\Configuration;
use Bookshelf\DataType\Book;
use Bookshelf\Utility\ErrorHandler;
use Bookshelf\Utility\ErrorLevel;

class DatabaseConnection {
    private $mysqli;

    public function __construct() {
        $config = new Configuration(false);

        $this->mysqli = new \mysqli($config->getDatabaseHost(), $config->getDatabaseUser(), $config->getDatabasePassword(), $config->getDatabaseName());

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

    // TODO: Implement proper methods for certain database actions; ideally we don't want to directly run SQL queries at all
    public function executeQuery($query) {
        $result = $this->mysqli->query($query);

        return $result->fetch_array();
    }

    // should not be called directly, only use from LibraryManager::addBook
    public function insertLibraryData($book) {
        $file_name = $book->original_name . $book->original_extension;
        $uuid = $book->uuid;
        $cover_image = $book->metadata->cover_image;
        $title = $book->metadata->title;
        $author = $book->metadata->author;
        $description = $book->metadata->description;
        $language = $book->metadata->language;
        $identifier = $book->metadata->identifier;

        $query = "INSERT INTO library (file_name, uuid, cover_image, title, author, description, language, identifier) VALUES ('{$file_name}', '{$uuid}', '{$cover_image}', '{$title}', '{$author}', '{$description}', '{$language}', '{$identifier}')";
        $this->mysqli->query($query);
    }
    
    public function selectLibraryData($conditions = null, $fields = null) {
        if($conditions === null) $conditions = array();
        if($fields === null) $fields = array();
        
        $fields_query = (empty($fields) ? '*' : join(', ', $fields));
        $query = "SELECT {$fields_query} FROM library WHERE";
        $condition_count = 0;
        if(isset($conditions['id'])) {
            $query .= ' id = ' . "'" . $conditions['id'] . "'";
            $condition_count++;
        } 
        if (isset($condtions['file_name'])) {
            $query .= ($condition_count > 0 ? ' AND ' : ' ') . "'" . $conditions['file_name'] . "'";
            $condition_count++;
        }
        if (isset($condtions['file_hash'])) {
            $query .= ($condition_count > 0 ? ' AND ' : ' ') . "'" . $conditions['file_hash'] . "'";
            $condition_count++;
        }
        if($condition_count == 0) $query .= ' 1';

        $result = $this->mysqli->query($query);

        return $result->fetch_assoc();
    }
}
