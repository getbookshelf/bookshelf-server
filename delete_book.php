<?php
// NOTE: This file only contains a demo implementation, it will likely not be included in the actual software!

session_start();
include(__DIR__ . '/inc/auth.php');

include(__DIR__ . '/inc/header.php');
echo '<a href="index.php">back</a><br>';

if(isset($_POST['chosen_book'])) {
    $library_manager = new \Bookshelf\Core\LibraryManager();

    foreach($_POST['chosen_book'] as $uuid) {
        $book_id = $library_manager->getBook('uuid', $uuid, true);
        $library_manager->deleteBook($book_id);
    }

    echo '<br>Delete successful.';
}
else {
    \Bookshelf\Utility\ErrorHandler::throwError('No books to delete.', \Bookshelf\Utility\ErrorLevel::ERROR);
}
include( __DIR__ . '/inc/footer.php');
