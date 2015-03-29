<?php
// NOTE: This file only contains a demo implementation, it will likely not be included in the actual software!
require_once __DIR__ . '/inc/base.php';
insertHeader();

echo '<a href="index.php">back</a><br>';

if(isset($_POST['id'])) {
    $library_manager = new \Bookshelf\Core\LibraryManager();

    foreach($_POST['id'] as $uuid) {
        $book_id = $library_manager->getBook('uuid', $uuid, true);
        $library_manager->deleteBook($book_id);
    }

    echo '<br>Delete successful.';
}
else {
    \Bookshelf\Utility\ErrorHandler::throwError('No book to delete.', \Bookshelf\Utility\ErrorLevel::ERROR);
}
insertFooter();
