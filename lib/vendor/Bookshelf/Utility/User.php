<?php

namespace Bookshelf\Utility;

use Bookshelf\Core\Configuration;
use Bookshelf\DataIo\DatabaseConnection;

class User {

    // TODO: Implement proper OO User class, currently I am just using the old functions as statics
    public static function isAuthenticated($name, $password) {
        $db_con = new DatabaseConnection();
        return $db_con->validateUser($name, $password);
    }

    public static function showLoginForm() {
        $config = new Configuration(true);
        $base_url = $config->getBaseUrl();

        print '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Bookshelf</title>
        <link rel="stylesheet" href="' . $base_url . '/assets/css/style.css">
    </head>
    <body>
        <div id="wrapper" name="wrapper">
            <header>
                <div class="container">
                    <span id="logo" name="logo">Bookshelf</span>
                </div>
            </header>
            <div id="main" name="main">
                <div class="container">
                    <form id="login-form" name="login-form" action="#" method="post">
                        <h1>Login</h1>
                        <p>This area can only be accessed by authorized users.</p>
                        <p><input type="text" name="name" placeholder="Name" required="" autofocus="" /><br>
                        <input type="password" name="password" placeholder="Password" required=""/></p>
                        <button type="submit">Login</button>
                    </form>
                </div>
            </div>
            <footer>
                <div class="container">
                    (c) ' . date('Y') . ' <a href="http://getbookshelf.org">the Bookshelf project</a>
                </div>
            </footer>
        </div>
    </body>
</html>';
    }

}
