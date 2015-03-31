<?php
require_once __DIR__ . '/inc/base.php';

$id = $_GET['id'];
if(empty($id)) {
    \Bookshelf\Utility\ErrorHandler::throwError('No book specified.', \Bookshelf\Utility\ErrorLevel::ERROR);
    header('Location: index.php');
    exit();
}

$lib_man = new \Bookshelf\Core\LibraryManager();
$book = $lib_man->getBookById($id);
$config = new \Bookshelf\Core\Configuration(true);
$base_url = $config->getBaseUrl();
$file = $config->getLibraryDir() . '/' . $book->uuid . $book->original_extension;

$mime_type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file);

switch($mime_type) {
    case 'application/epub+zip':
    include __DIR__ . '/inc/reader-epub/reader.php';
    break;
    case 'application/pdf':
        include __DIR__ . '/inc/reader-pdf/web/viewer.php';
        break;
    default:
        insertHeader();
        echo '<p>Unfortunately, viewing files of that type online is currently not supported.<br>You can always <a href="' . $base_url . '/download.php?id=' . $id . '">download</a> the file and read it on your computer, though.</p>';
        echo '<p>Go back to the ebook <a href="' . $base_url . '/book.php?id=' . $id . '">detail page</a>.</p>';
        insertFooter();
}
