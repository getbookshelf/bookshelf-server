<?php

namespace Bookshelf\Core;

use Bookshelf\DataIo\DatabaseConnection;

class Configuration {
    private $ini_data;
    private $db_connection;

    public function __construct($enable_db = true) {
        $this->ini_data = parse_ini_file(Application::ROOT_DIR . 'config.ini');
        if($enable_db) $this->db_connection = new DatabaseConnection();
    }

    public function getLibraryDir() {
        return $this->db_connection->readConfigValue('library_dir');
    }

    public function getDebuggingEnabled() {
        return $this->db_connection->readConfigValue('enable_debugging');
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
}