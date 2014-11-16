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
    public function insertBook($data) {
        $query = "INSERT INTO library (file_name, uuid, cover_image, title, author, description, language, identifier) VALUES ('{$data['file_name']}', '{$data['uuid']}', '{$data['cover_image']}', '{$data['title']}', '{$data['author']}', '{$data['description']}', '{$data['language']}', '{$data['identifier']}')";
        $this->mysqli->query($query);

        return $this->mysqli->insert_id;
    }

    public function deleteBook($id) {
        $query = "DELETE FROM library WHERE id={$id}";
        $this->mysqli->query($query);
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
        } else {
            ErrorHandler::throwError('Getting book with ID ' . $id . ' failed.', ErrorLevel::DEBUG);
        }
        return false;
    }

    public function getIdByUuid($uuid) {
        if($result = $this->mysqli->query("SELECT id FROM library WHERE uuid LIKE '{$uuid}'")) return $result->fetch_array(MYSQL_ASSOC)['id'];
        return -1;
    }

    // TODO: Decide on how we want to query the db for books (search all columns, just some specific ones, specify by parameter...?)
    public function getBook($field, $contains) {
        if($result = $this->mysqli->query("SELECT id FROM library WHERE {$field} LIKE '%{$contains}%'")) return $result->fetch_array(MYSQL_ASSOC);
        return -1;
    }

    public function dumpLibraryData() {
        if($result = $this->mysqli->query("SELECT * FROM library")) return $this->fetch_all($result);
    }

    public function escape($string) {
        return $this->mysqli->real_escape_string($string);
    }

    private function fetch_all($result) {
        $all = array();
        while($row = $result->fetch_array(MYSQL_ASSOC)){
            $all[] = $row;
        }
        return $all;
    }
}
