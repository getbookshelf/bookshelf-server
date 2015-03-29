<?php
require_once __DIR__ . '/inc/base.php';
insertHeader();

$library_manager = new \Bookshelf\Core\LibraryManager();
$book_list = $library_manager->listBooks();

echo '<a href="index.php">back</a><br>';
echo '<form action="delete_book.php" method="post"><table>';
foreach($book_list as $book) {

    echo $book->metadata->toHtmlTableRow('checkbox', $book->uuid, $library_manager->getBook('uuid', $book->uuid, true));
}
echo '</table><input type="submit" value="Delete"></form>';

insertFooter();
