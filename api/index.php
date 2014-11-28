<?php
require __DIR__ . '../lib/vendor/autoload.php';

$request = new \Bookshelf\DataType\ApiRequest($_POST);
$lib_man = new \Bookshelf\Core\LibraryManager();
$file_man = new \Bookshelf\DataIo\FileManager();

$result = array();

switch ($request->action) {
    case 'addbook':
        $result['id'] = $file_man->uploadBook($_FILES);
        break;
    case 'deletebook':
        break;
    case 'getbook':
        break;
    case 'listbooks':
        break;
    case 'updatebook':
        break;
    default:
        \Bookshelf\Utility\ErrorHandler::throwError('Unrecognized action.', \Bookshelf\Utility\ErrorLevel::WARNING);
}

echo json_encode($result);