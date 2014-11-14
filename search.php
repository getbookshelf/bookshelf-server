<?php
// NOTE: This file only contains a demo implementation, it will likely not be included in the actual software!
require __DIR__ . '/lib/vendor/autoload.php';
session_start();
include(__DIR__ . '/inc/auth.php');

include( __DIR__ . '/inc/header.php');

if(!isset($_POST['id'])) {
    \Bookshelf\Utility\ErrorHandler::throwError('No request.', \Bookshelf\Utility\ErrorLevel::WARNING);
    header('Location: index.php');
    exit();
}

$id = $_POST['id'];
$library_mgr = new \Bookshelf\Core\LibraryManager();
$book = $library_mgr->getBookById($id);
if($book === null) {
    \Bookshelf\Utility\ErrorHandler::throwError('Book does not exist.', \Bookshelf\Utility\ErrorLevel::ERROR);
    header('Location: index.php');
    exit();
}

$gb_request = new \Bookshelf\ExternalApi\GoogleBooksApiRequest();
$gb_request->volumeSearch($book->getQueryString(), 3);

echo '<h1>Results for \'' . htmlspecialchars($gb_request->getRequestString()) . '\'</h1>';
echo '<a href="index.php">back</a><br>';
echo '<form method="post" action="update_book.php">';
echo '<input type="hidden" name="id" value="' . $id . '">';
echo $gb_request->results()->toHtmlTable(true);
echo '<input type="submit" value="Update metadata">';
echo '</form>';

include( __DIR__ . '/inc/footer.php');
