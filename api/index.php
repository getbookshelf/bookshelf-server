<?php
require __DIR__ . '/../lib/vendor/autoload.php';

$request = new \Bookshelf\DataIo\ApiRequest($_POST);
$lib_man = new \Bookshelf\Core\LibraryManager();
$file_man = new \Bookshelf\DataIo\FileManager();

$result = array();

switch($request->action) {
    case 'addbook':
        $result['id'] = $file_man->uploadBook($_FILES);
        break;
    case 'deletebook':
        if(isset($request->id)) {
            $lib_man->deleteBook($request->id);
            // TODO: How to handle successful requests?
        }
        break;
    case 'getbook':
        break;
    case 'listbooks':
        break;
    case 'updatebook':
        break;
    default:
        // TODO: The API currently doesn't use sessions => ErrorHandler won't work
        //\Bookshelf\Utility\ErrorHandler::throwError('Unrecognized action.', \Bookshelf\Utility\ErrorLevel::WARNING);
}

echo json_encode($result);
