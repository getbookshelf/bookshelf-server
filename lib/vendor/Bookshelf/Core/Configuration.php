<?php

namespace Bookshelf\Core;

use Bookshelf\DataIo\DatabaseConnection;
use Bookshelf\Utility\ErrorHandler;
use Bookshelf\Utility\ErrorLevel;

class Configuration {
    private $ini_data;
    private $db_connection;

    public function __construct($enable_db = true, $db_con = null) {
        $this->ini_data = parse_ini_file(Application::ROOT_DIR . '/config.ini');
        if($enable_db) {
            $this->db_connection = $db_con == null ? new DatabaseConnection() : $db_con;
        }
    }

    public function getLibraryDir() {
        $lib_dir = $this->getDatabaseValue('library_dir');
        return rtrim($lib_dir, '/');
    }

    public function getDebuggingEnabled() {
        return (bool)$this->getDatabaseValue('enable_debugging');
    }

    public function getBaseUrl() {
        $base_url = $this->getDatabaseValue('base_url');
        return rtrim($base_url, '/');
    }

    public function getDatabaseHost() {
        return $this->ini_data['db_host'];
    }

    public function getDatabaseUser() {
        return $this->ini_data['db_user'];
    }

    public function getDatabasePassword() {
        return $this->ini_data['db_pw'];
    }

    public function getDatabaseName() {
        return $this->ini_data['db_name'];
    }

    public function getSalt() {
        return $this->ini_data['salt'];
    }

    private function getDatabaseValue($property) {
        if($this->db_connection === null) {
            ErrorHandler::throwError('Trying to read configuration from database with uninitialized DatabaseConnection.', ErrorLevel::DEBUG);
        }

        return $this->db_connection->readConfigValue($property);
    }
}
