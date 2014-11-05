<?php

namespace Bookshelf\Utility;

use Bookshelf\DataIo\DatabaseConnection;

class User {

    // TODO: Implement proper OO User class, currently I am just using the old functions as statics
    public static function isAuthenticated($name, $password) {
        $db_con = new DatabaseConnection();
        return $db_con->validateUser($name, $password);
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