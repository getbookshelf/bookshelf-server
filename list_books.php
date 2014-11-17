<?php
require __DIR__ . '/lib/vendor/autoload.php';
session_start();
include(__DIR__ . '/inc/auth.php');

include( __DIR__ . '/inc/header.php');

$library_manager = new \Bookshelf\Core\LibraryManager();
$book_list = $library_manager->listBooks();

echo '<form action="delete_book.php" method="post"><table>';
foreach($book_list as $book) {
    echo $book->metadata->toHtmlTableRow('checkbox', $book->uuid);
}
echo '</table><input type="submit" value="Delete"></form>';

include( __DIR__ . '/inc/footer.php');
