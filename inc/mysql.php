<?php
include(__DIR__ . '/../config.php');
$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PW, $DB_NAME);

if(mysqli_connect_errno()) {
    echo 'Couldn\'nt connect to database.';
}