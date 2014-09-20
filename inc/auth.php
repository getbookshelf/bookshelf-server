<?php
if(!isset($_SESSION['name'])) {
    if(!isset($_POST['password'])) {
        session_destroy();
        $_SESSION = array();
        include(__DIR__ . '/login.php');
        exit();
    }
    else {
        require_once(__DIR__ . '/functions.php');
        require_once(__DIR__ . '/mysql.php');
        if(authenticated($_POST['name'], $_POST['password'])) {
            $_SESSION['name'] = $_POST['name'];
        }
        else {
            header('Location: index.php');
        }
    }
}
