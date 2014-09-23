<?php
require_once(__DIR__ . '/../lib/vendor/autoload.php');

if(!isset($_SESSION['name'])) {
    if(!isset($_POST['password'])) {
        session_destroy();
        $_SESSION = array();
        \Bookshelf\Utility\User::show_login_form();
        exit();
    }
    else {
        if(Bookshelf\Utility\User::is_authenticated($_POST['name'], $_POST['password'])) {
            $_SESSION['name'] = $_POST['name'];
        }
        else {
            header('Location: index.php');
        }
    }
}
