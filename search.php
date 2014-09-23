<?php
require __DIR__ . '/lib/vendor/autoload.php';
session_start();
include(__DIR__ . '/inc/auth.php');

include( __DIR__ . '/inc/header.php');

if(!isset($_POST['request'])) {
    //Error: No request.
    header('Location: index.php');
    exit();
}
$request = $_POST['request'];

$gb_request = new \Bookshelf\ExternalApi\GoogleBooksApiRequest();
$gb_request->volume_search($request, 3);

echo '<h1>Results for \'' . htmlspecialchars($gb_request->get_request_string()) . '\'</h1>';
echo '<a href="index.php">back</a><br>';
print_r($gb_request->results());
