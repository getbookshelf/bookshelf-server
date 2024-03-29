<?php

function insertHeader($title = '', $additional_head_content = '') {
    $config = new \Bookshelf\Core\Configuration(true);
    $updater = new \Bookshelf\Utility\Updater();

    $title = $title == '' ? '' : $title . ' - ';
    $base_url = $config->getBaseUrl();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?>Bookshelf</title>
        <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
        <?php echo $additional_head_content; ?>
    </head>
    <body>
    <div id="wrapper">
        <header>
            <div class="container">
                <span id="logo"><a href="<?php echo $base_url; ?>/index.php">Bookshelf</a></span>
                <nav>
                    <span class="nav-item"><a href="<?php echo $base_url; ?>/index.php">All</a></span>
                    <span class="nav-item"><a href="<?php echo $base_url; ?>/search.php?filter=author">Authors</a></span>
                    <span class="nav-item"><a href="<?php echo $base_url; ?>/search.php?filter=lang">Languages</a></span>
                    <span class="nav-item"><a href="<?php echo $base_url; ?>/search.php?filter=categories">Categories</a></span>
                    <form id="search-form" method="get" action="<?php echo $base_url; ?>/search.php"><input id="search-bar" name="query" type="text" placeholder="Search..."></form>
                </nav>
            </div>
        </header>
        <div id="main">
            <div class="container">
                <div id="user-menu">
                    Hi there, <?php echo $_SESSION["name"]; ?>.

                    <p>
                        <a href="<?php echo $base_url; ?>/upload.php">Add new book</a><br>
                        <a href="<?php echo $base_url; ?>/settings.php">Settings</a><br>
                        <a href="<?php echo $base_url; ?>/logout.php">Logout</a>
                    </p>
                </div>
    <?php
    \Bookshelf\Utility\ErrorHandler::displayErrors();

    if($updater->update_necessary) {
        if($updater->update_possible) {
            echo '<div class="message">An update is available. Click <a href="' . $base_url . '/update.php">here</a> to install it.</div>';
        }
        else {
            echo '<div class="message">An update is available but it cannot be installed automatically. Click <a href="' . $base_url . '/update.php">here</a> to find out more.</div>';
        }
    }
}

function insertFooter($additional_scripts = '') {
    $config = new \Bookshelf\Core\Configuration(true);
    $base_url = $config->getBaseUrl();

    \Bookshelf\Utility\ErrorHandler::displayErrors(true);
    ?>
    </div>
    </div>
    <footer>
        <div class="container">
            (c) <?php echo date('Y'); ?> <a href="http://getbookshelf.org">The Bookshelf project</a>
        </div>
    </footer>
    </div>
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="<?php echo $base_url; ?>/assets/js/bookshelf.js"></script>
    <?php
    if($additional_scripts) {
        echo '<script>' . $additional_scripts . '</script>';
    }
    ?>
    </body>
    </html>
    <?php
}
