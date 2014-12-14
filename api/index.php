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
        else {
            // TODO: Throw error
        }
        break;
    case 'getbookmeta':
        if(isset($request->id)) {
            $book = $lib_man->getBookById($request->id);

            $result = $book->metadata->toArray();
        }
        else {
            // TODO: Throw error
        }
        break;
    case 'downloadbook':
        if(isset($request->id)) {
            $book = $lib_man->getBookById($request->id);

            $book->download();
        }
        else {
            // TODO: Throw error
        }
        break;
    case 'searchbook':
        if(isset($request->field) && isset($request->query)) {
            $result['id'] = $lib_man->getBook($request->field, $request->query);
        }
        else {
            // TODO: Throw error
        }
        break;
    case 'listbooks':
        $result = $lib_man->listBooks();
        break;
    case 'updatebook':
        break;
    default:
        // TODO: The API currently doesn't use sessions => ErrorHandler won't work
        //\Bookshelf\Utility\ErrorHandler::throwError('Unrecognized action.', \Bookshelf\Utility\ErrorLevel::WARNING);
}

echo json_encode($result);
