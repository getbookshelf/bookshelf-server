<?php

function insertHeader($title = '', $additional_head_content = '') {
    $config = new \Bookshelf\Core\Configuration(true);

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
    <div id="wrapper" name="wrapper">
        <header>
            <div class="container">
                <span id="logo" name="logo"><a href="index.php">Bookshelf</a></span>
                <nav>
                    <span class="nav-item"><a href="#">All</a></span>
                    <span class="nav-item"><a href="#">Authors</a></span>
                    <span class="nav-item"><a href="#">Languages</a></span>
                    <span class="nav-item"><a href="#">Something Else</a></span>
                    <input name="search-bar" type="text" placeholder="Search...">
                </nav>
            </div>
        </header>
        <div id="main" name="main">
            <div class="container">
    <?php
    \Bookshelf\Utility\ErrorHandler::displayErrors();
}

function insertFooter() {
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
    </body>
    </html>
    <?php
}
