<?php
require __DIR__ . '/../lib/vendor/autoload.php';

if(\Bookshelf\Utility\User::isAuthenticated($_POST['user'], $_POST['password'])) {
    $request = new \Bookshelf\DataIo\ApiRequest($_POST);
    $lib_man = new \Bookshelf\Core\LibraryManager();
    $file_man = new \Bookshelf\DataIo\FileManager();
    $db_con = new \Bookshelf\DataIo\DatabaseConnection();

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
            if(isset($request->id)) {
                $to_update = array();

                if(!empty($request->book_meta->author)) $to_update['author'] = $request->book_meta->author;
                if(!empty($request->book_meta->cover_image)) $to_update['cover_image'] = $request->book_meta->cover_image;
                if(!empty($request->book_meta->description)) $to_update['description'] = $request->book_meta->description;
                if(!empty($request->book_meta->identifier)) $to_update['identifier'] = $request->book_meta->identifier;
                if(!empty($request->book_meta->language)) $to_update['language'] = $request->book_meta->language;
                if(!empty($request->book_meta->title)) $to_update['title'] = $request->book_meta->title;

                $db_con->updateBook($request->id, $to_update);
            }
            else {
                // TODO: Throw error
            }
            break;
        default:
            // TODO: The API currently doesn't use sessions => ErrorHandler won't work
            //\Bookshelf\Utility\ErrorHandler::throwError('Unrecognized action.', \Bookshelf\Utility\ErrorLevel::WARNING);
    }
}
else {
    http_response_code(401);
    $result['error_code'] = 401;
    $result['error'] = 'Not authenticated.';
}

echo json_encode($result);
