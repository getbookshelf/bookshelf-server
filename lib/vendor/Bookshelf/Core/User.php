<?php

namespace Bookshelf\Core;

use Bookshelf\DataIo\DatabaseConnection;

class User {

    // TODO: Implement proper OO User class, currently I am just using the old functions as statics
    public static function is_authenticated($name, $password) {
        $databaseConnection = new DatabaseConnection();
        require Constants::$root_dir . 'config.php';

        $row = $databaseConnection->execute_query("SELECT passwd_hash FROM users WHERE username='$name'");

//        echo hash('sha256', $password . $SALT) . '<br>';
//        echo $DB_PW;
//        echo $row['passwd_hash'];
//        exit;

        if(hash('sha256', $password . $SALT) == $row['passwd_hash']){
            return true;
        }
        else {
            return false;
        }
    }

    public static function show_login_form() {
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