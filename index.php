<?php
require_once __DIR__ . '/inc/base.php';
insertHeader();

$lib_man = new \Bookshelf\Core\LibraryManager();
$config = new \Bookshelf\Core\Configuration(true);
$books = $lib_man->listBooks();
$base_url = $config->getBaseUrl();
?>
<?php

foreach($books as $book) {
    echo '<a href="book.php?id=' . $lib_man->getBook('uuid', $book->uuid, true) . '"><img class="book" src="' . $book->metadata->cover_image . '"></a>';
}
echo '<a href="' . $base_url . '/upload.php"><div class="book-upload">+</div></a>';

insertFooter();
