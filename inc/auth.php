<?php
    if(!isset($_SESSION['name'])) {
        if(!isset($_POST['password'])) {
            session_destroy();
            $_SESSION = array();
            include(__DIR__ . '/login.php');
            exit();
        }
        else {
            require_once(__DIR__ . '/../../inc/auth.php');
            require_once(__DIR__ . '/../../inc/mysql.php');
            if(authenticated($POST_['name'], $_POST['password'])) {
                   $_SESSION['name'] = $_POST['name'];
                   $_SESSION['password'] = $_POST['password'];
            } 
            else {
                header("Location:index.php");
            }
        }
    }
