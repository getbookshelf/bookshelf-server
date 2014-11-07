<?php
require __DIR__ . '/lib/vendor/autoload.php';
session_start();
include(__DIR__ . '/inc/auth.php');

include( __DIR__ . '/inc/header.php');

$library_manager = new \Bookshelf\Core\LibraryManager();
$book_list = $library_manager->listBooks();

print_r($book_list);

include( __DIR__ . '/inc/footer.php');
