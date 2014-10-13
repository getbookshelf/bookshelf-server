<?php

namespace Bookshelf\DataIo;

use Bookshelf\Core\Application;
use Bookshelf\Utility\ErrorHandler;
use Bookshelf\Utility\ErrorLevel;

class DatabaseConnection {
    private $mysqli;

    public function __construct() {
        require Application::ROOT_DIR . 'config.php';

        $this->mysqli = new \mysqli($DB_HOST, $DB_USER, $DB_PW, $DB_NAME);

        if($this->mysqli->connect_errno) {
            ErrorHandler::throwError('Could not connect to database.', ErrorLevel::CRITICAL);
            return;
        }
    }

    // TODO: Implement proper methods for certain database actions; ideally we don't want to directly run SQL queries at all
    public function executeQuery($query) {
        $result = $this->mysqli->query($query);

        return $result->fetch_array();
    }

    // should not be called directly, only use from LibraryManager::addBook($file_name, $metadata)
    public function insertLibraryData($args) {
        $columns = join(', ', array_keys($args));
        $values = join(', ', $args);
        $query = "INSERT INTO library ({$columns}) VALUES ({$values})";
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
