<?php
require __DIR__ . '/lib/vendor/autoload.php';
session_start();
include(__DIR__ . '/inc/auth.php');

include( __DIR__ . '/inc/header.php');

$id = $_GET['id'];
if(!empty($id)) {
    $lib_man = new \Bookshelf\Core\LibraryManager();
    $book = $lib_man->getBookById($id);

    if($book == new \Bookshelf\DataType\Book('','','')) {
        \Bookshelf\Utility\ErrorHandler::throwError('Book not found.', \Bookshelf\Utility\ErrorLevel::ERROR);
        header('Location: index.php');
        exit();
    }

    echo '<img class="book-detail" src="' . $book->metadata->cover_image . '">';
    echo '<div id="book-info"><h1>' . $book->metadata->title . '</h1>by <span class="author">' . $book->metadata->author .'</span></div>';
    echo '<p>' . $book->metadata->description . '</p>';
    echo '<p><a href="download.php?id=' . $id .'">Download book</a> <a href="delete_book.php?id=' . $id . '">Delete book</a></p>';
}
else {
    \Bookshelf\Utility\ErrorHandler::throwError('No book selected.', \Bookshelf\Utility\ErrorLevel::ERROR);
    header('Location: index.php');
    exit();
}

include( __DIR__ . '/inc/footer.php');

// line HEIGHT!
