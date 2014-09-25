<?php

namespace Bookshelf\DataIo;

use Bookshelf\Core\Application;

class DatabaseConnection {
    private $con;

    function __construct() {
        require Application::ROOT_DIR . 'config.php';

        $this->con = mysqli_connect($DB_HOST, $DB_USER, $DB_PW, $DB_NAME);

        if(mysqli_connect_errno()) {
            echo 'Could not connect to database.';
        }
    }

    // TODO: Implement proper methods for certain database actions; ideally we don't want to directly run SQL queries at all
    function execute_query($query) {
        $result = mysqli_query($this->con, $query);

        return mysqli_fetch_array($result);
    }
    
    function insertLibraryData($args) {
        $columns = join(', ', array_keys($args));
        $values = join(', ', $args);
        $sql = "INSERT INTO library ($columns) VALUES ($values)";
        mysqli_query($this->con, $sql);
    }
}
