<?php
require __DIR__ . '/lib/vendor/autoload.php';
session_start();
include(__DIR__ . '/inc/auth.php');

include( __DIR__ . '/inc/header.php');

if(!isset($_POST['request'])) {
    \Bookshelf\Utility\ErrorHandler::throwError('No request.', \Bookshelf\Utility\ErrorLevel::WARNING);
    header('Location: index.php');
    exit();
}
$request = $_POST['request'];

$gb_request = new \Bookshelf\ExternalApi\GoogleBooksApiRequest();
$gb_request->volumeSearch($request, 3);

echo '<h1>Results for \'' . htmlspecialchars($gb_request->getRequestString()) . '\'</h1>';
echo '<h2>Choose the metadata fitting your book the best.</h2>';
echo '<a href="index.php">back</a><br>';
$gb_request->results();
