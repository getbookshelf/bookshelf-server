<?php
require __DIR__ . '/../lib/vendor/autoload.php';

header("Content-Type: text/json");

$api_reply = array(
    'status_code' => 200,
    'status' => 'OK.'
);
http_response_code(200);
$result = array();

session_start();
if(\Bookshelf\Utility\User::isAuthenticated($_POST['user'], $_POST['password']) || isset($_SESSION['name'])) {
    $request = new \Bookshelf\DataIo\ApiRequest($_POST);
    $lib_man = new \Bookshelf\Core\LibraryManager();
    $file_man = new \Bookshelf\DataIo\FileManager();

    switch($request->action) {
        case 'addbook':
            $result['id'] = $file_man->uploadBook($_FILES);
            break;
        case 'deletebook':
            if(isset($request->id)) {
                $lib_man->deleteBook($request->id);
            }
            else {
                http_response_code(400);
                $api_reply['status_code'] = 602;
                $api_reply['status'] = 'Missing parameters (id).';
            }
            break;
        case 'getbookmeta':
            if(isset($request->id)) {
                $book = $lib_man->getBookById($request->id);

                $result = $book->metadata->toArray();
            }
            else {
                http_response_code(400);
                $api_reply['status_code'] = 602;
                $api_reply['status'] = 'Missing parameters (id).';
            }
            break;
        case 'downloadbook':
            if(isset($request->id)) {
                $book = $lib_man->getBookById($request->id);

                $book->download();
            }
            else {
                http_response_code(400);
                $api_reply['status_code'] = 602;
                $api_reply['status'] = 'Missing parameters (id).';
            }
            break;
        case 'searchbook':
            if(isset($request->field) && isset($request->query)) {
                $result['id'] = $lib_man->getBook($request->field, $request->query);
            }
            else {
                http_response_code(400);
                $api_reply['status_code'] = 602;
                $api_reply['status'] = 'Missing parameters (field, query).';
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
                if(!empty($request->book_meta->tags)) $to_update['tags'] = $request->book_meta->tags;

                $lib_man->updateBook($request->id, $to_update);
            }
            else {
                http_response_code(400);
                $api_reply['status_code'] = 602;
                $api_reply['status'] = 'Missing parameters (id).';
            }
            break;
        default:
            http_response_code(400);
            $api_reply['status_code'] = 601;
            $api_reply['status'] = 'Invalid action.';
    }
}
else {
    http_response_code(401);
    $api_reply['status_code'] = 401;
    $api_reply['status'] = 'Not authenticated.';
}

$api_reply['result'] = $result;
echo json_encode($api_reply);
