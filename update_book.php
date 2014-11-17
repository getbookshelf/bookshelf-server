<?php
// NOTE: This file only contains a demo implementation, it will likely not be included in the actual software!
session_start();
include(__DIR__ . '/inc/auth.php');

include(__DIR__ . '/inc/header.php');

if(!isset($_POST['id']) || !isset($_POST['chosen_book'])) {
    \Bookshelf\Utility\ErrorHandler::throwError('No request.', \Bookshelf\Utility\ErrorLevel::WARNING);
    header('Location: index.php');
    exit();
}

$db_con = new \Bookshelf\DataIo\DatabaseConnection();
$id = $_POST['id'];
$used_api = explode('.', $_POST['chosen_book'][0], 2)[0];
$api_id = explode('.', $_POST['chosen_book'][0], 2)[1];

switch($used_api) {
    case 'GoogleBooks':
        $api_request = new \Bookshelf\ExternalApi\GoogleBooksApiRequest();
        $api_request->getBookByIdentifier($api_id);
        $result = $api_request->results()->getResults()[0]['metadata'];

        $cover_image = $db_con->escape($result->cover_image);
        $title = $db_con->escape($result->title);
        $author = $db_con->escape($result->author);
        $description = $db_con->escape($result->description);
        $language = $db_con->escape($result->language);
        $identifier = $db_con->escape($result->identifier);

        $to_update = array('cover_image' => $cover_image, 'title' => $title, 'author' => $author, 'description' => $description, 'language' => $language, 'identifier' => $identifier);

        $db_con->updateBook($id, $to_update);
        echo 'Update successful.';
        echo '<br><a href="index.php">go back</a>';

        break;
    default:
        \Bookshelf\Utility\ErrorHandler::throwError('Did not recognize API result.', \Bookshelf\Utility\ErrorLevel::WARNING);
}

include( __DIR__ . '/inc/footer.php');
