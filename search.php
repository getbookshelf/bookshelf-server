<?php
require_once __DIR__ . '/inc/base.php';
insertHeader();

$query = $_GET['query'];
$filter = $_GET['filter'];

$lib_man = new \Bookshelf\Core\LibraryManager();
$db_con = new \Bookshelf\DataIo\DatabaseConnection();
$config = new \Bookshelf\Core\Configuration(true, $db_con);
$base_url = $config->getBaseUrl();

if(!empty($query)) {
    echo '<h1>Results for "' . $db_con->purify($query) . '"</h1>';

    $books = $lib_man->search($query);
    foreach($books as $book) {
        echo '<a href="book.php?id=' . $lib_man->getBook('uuid', $book->uuid, true) . '"><img class="book" src="' . $book->metadata->cover_image . '"></a>';
    }
    if(count($books) == 0) {
        echo 'No books that match your query were found.';
    }
}
elseif(!empty($filter)) {
    if($filter == 'author') {
        echo '<h1>Filtering by author</h1>';
    }
    elseif($filter == 'lang') {
        echo '<h1>Filtering by language</h1>';
    }
    elseif($filter == 'categories') {
        echo 'Filtering by category is currently not implemented. Please check back soon.';
        insertFooter();
        exit;
    }

    $renames = array('desc' => 'description', 'isbn' => 'identifier', 'lang' => 'language');
    $values = $lib_man->dumpDistinctLibraryData(str_replace(array_keys($renames), $renames, $filter));
    if(empty($values)) {
        echo 'No books found.';
        exit();
    }

    foreach($values as $value) {
        echo '<h2>' . $value . '</h2>';
        $books = $lib_man->search($filter . ': ' . $value);
        foreach($books as $book) {
            echo '<a href="book.php?id=' . $lib_man->getBook('uuid', $book->uuid, true) . '"><img class="book" src="' . $book->metadata->cover_image . '"></a>';
        }
    }
}
else {
    \Bookshelf\Utility\ErrorHandler::throwError('No query specified.', \Bookshelf\Utility\ErrorLevel::ERROR);
    header('Location: index.php');
    exit();
}

insertFooter();
