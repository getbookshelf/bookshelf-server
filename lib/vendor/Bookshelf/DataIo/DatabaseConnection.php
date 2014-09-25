<?php

namespace Bookshelf\DataIo;

use Bookshelf\Core\Application;

class DatabaseConnection {
    private $mysqli;

    function __construct() {
        require Application::ROOT_DIR . 'config.php';

        $this->mysqli = new \mysqli($DB_HOST, $DB_USER, $DB_PW, $DB_NAME);

        if($this->mysqli->connect_errno) {
            echo 'Could not connect to database.';
        }
    }

    // TODO: Implement proper methods for certain database actions; ideally we don't want to directly run SQL queries at all
    function execute_query($query) {
        $result = $this->mysqli->query($query);

        return $result->fetch_array();
    }
    
    function insertLibraryData($args) {
        $columns = join(', ', array_keys($args));
        $values = join(', ', $args);
        $query = "INSERT INTO library ($columns) VALUES ($values)";
        $this->mysqli->query($query);
    }
}
