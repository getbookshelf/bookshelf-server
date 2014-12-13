<?php
require __DIR__ . '/lib/vendor/autoload.php';
session_start();
include(__DIR__ . '/inc/auth.php');

if(isset($_GET['id'])) {
    $lib_man = new \Bookshelf\Core\LibraryManager();
    $book = $lib_man->getBookById($_GET['id']);

    $book->download();
}
else {
    \Bookshelf\Utility\ErrorHandler::throwError('No book specified.', \Bookshelf\Utility\ErrorLevel::ERROR);
}
