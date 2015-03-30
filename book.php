<?php
require_once __DIR__ . '/inc/base.php';
insertHeader();

$id = $_GET['id'];
if(!empty($id)) {
    $lib_man = new \Bookshelf\Core\LibraryManager();
    $config = new \Bookshelf\Core\Configuration(true);
    $book = $lib_man->getBookById($id);
    $base_url = $config->getBaseUrl();

    if($book == new \Bookshelf\DataType\Book('','','')) {
        \Bookshelf\Utility\ErrorHandler::throwError('Book not found.', \Bookshelf\Utility\ErrorLevel::ERROR);
        header('Location: index.php');
        exit();
    }

    echo '<img class="book-detail" src="' . $book->metadata->cover_image . '">';
    echo '<div id="book-info"><h1>' . $book->metadata->title . '</h1>by <span class="author">' . $book->metadata->author .'</span></div>';
    echo '<p>' . $book->metadata->description . '</p>';
    echo '<p><a href="download.php?id=' . $id .'">Download book</a><br><a href="edit-book.php?id=' . $id .'">Edit book</a><br><a href="#" onclick="deleteBook(\'' . $base_url . '\', ' . $id .');return false;">Delete book</a></p>';
}
else {
    \Bookshelf\Utility\ErrorHandler::throwError('No book selected.', \Bookshelf\Utility\ErrorLevel::ERROR);
    header('Location: index.php');
    exit();
}

insertFooter();
