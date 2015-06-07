<?php
require_once __DIR__ . '/inc/base.php';
insertHeader();

$query = $_GET['query'];
if(empty($query)) {
    \Bookshelf\Utility\ErrorHandler::throwError('No query specified.', \Bookshelf\Utility\ErrorLevel::ERROR);
    header('Location: index.php');
    exit();
}

$lib_man = new \Bookshelf\Core\LibraryManager();
$db_con = new \Bookshelf\DataIo\DatabaseConnection();
$config = new \Bookshelf\Core\Configuration(true, $db_con);
$books = $lib_man->search($query);
$base_url = $config->getBaseUrl();
?>
<h1>Results for '<?php echo $db_con->purify($query); ?>'</h1>
<?php

foreach($books as $book) {
    echo '<a href="book.php?id=' . $lib_man->getBook('uuid', $book->uuid, true) . '"><img class="book" src="' . $book->metadata->cover_image . '"></a>';
}

insertFooter();
