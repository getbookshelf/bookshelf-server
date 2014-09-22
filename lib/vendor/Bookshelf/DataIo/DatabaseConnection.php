<?php

namespace Bookshelf\DataIo;

use Bookshelf\Core\Constants;

class DatabaseConnection {
    private $con;

    function __construct() {
        require Constants::$ROOT_DIR . 'config.php';

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
}
