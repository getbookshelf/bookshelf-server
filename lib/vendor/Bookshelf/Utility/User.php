<?php

namespace Bookshelf\Utility;

use Bookshelf\Core\Application;
use Bookshelf\DataIo\DatabaseConnection;

class User {

    // TODO: Implement proper OO User class, currently I am just using the old functions as statics
    public static function isAuthenticated($name, $password) {
        $database_connection = new DatabaseConnection();
        require Application::ROOT_DIR . 'config.php';

        $row = $database_connection->executeQuery("SELECT passwd_hash FROM users WHERE username='$name'");

        if(hash('sha256', $password . $SALT) == $row['passwd_hash']){
            return true;
        }
        else {
            return false;
        }
    }

    public static function showLoginForm() {
        print '<div class="wrapper">
            <form action="#" method="post">
                <h2>Login</h2>
                <input type="text" name="name" placeholder="Name" required="" autofocus="" />
                <input type="password" name="password" placeholder="Password" required=""/>
                <button type="submit">Login</button>
            </form>
        </div>';
    }

} 