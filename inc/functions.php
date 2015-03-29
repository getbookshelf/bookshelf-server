<?php

function insertHeader($title = '', $additional_head_content = '') {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <?php
        $title = $title == '' ? '' : $title . ' - ';
        ?>
        <title><?php echo $title; ?>Bookshelf</title>
        <link rel="stylesheet" href="assets/css/style.css">
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
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="assets/js/bookshelf.js"></script>
    </body>
    </html>
    <?php
}
