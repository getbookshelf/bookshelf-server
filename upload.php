<?php
require_once __DIR__ . '/inc/base.php';
insertHeader();

$current_step = $_POST['step'];
$additional_scripts = '';

switch($current_step) {
    case '':
        ?>
        <h1>Upload eBook</h1>
        <form enctype="multipart/form-data" action="#" method="POST">
            <input name="step" type="hidden" value="search">
            <input name="file" type="file"><br>
            <input type="submit" value="Upload">
        </form>
        <?php
        break;
    case 'search':
        if(isset($_FILES['file'])) {
            $file_manager = new \Bookshelf\DataIo\FileManager();
            $config = new \Bookshelf\Core\Configuration(true);
            $uploaded_book_id = $file_manager->uploadBook($_FILES);
            $base_url = $config->getBaseUrl();

            $library_mgr = new \Bookshelf\Core\LibraryManager();
            $book = $library_mgr->getBookById($uploaded_book_id);
            if($book === null) {
                \Bookshelf\Utility\ErrorHandler::throwError('Book does not exist.', \Bookshelf\Utility\ErrorLevel::ERROR);
                header('Location: index.php');
                exit();
            }

            echo '<h1>Set book metadata</h1>
<p>Your book <span class="italic">' . $_FILES['file']['name'] . '</span> has been uploaded successfully. You can now set its metadata. If none of the API\'s metadata matches your book, you can always <a href="' . $base_url . '/edit-book.php?id=' . $id . '">manually edit</a> the metadata.</p>';
            echo '<p>
Query: <input id="query_string" name="query_string" type="text" value="' . $book->getQueryString() . '"> <button id="btn-search" name="btn-search">Search</button>
</p>';
            echo '<div id="searchform"></div>';

            $additional_scripts = '$("#btn-search").click(function() {
        $("#searchform").html("<p>Loading...</p>");
        $.ajax({
            context: this,
            dataType: "html",
            type: "POST",
            data: {
                id: "' . $uploaded_book_id . '",
                query_string: $("#query_string").val(),
            },
            url: "' . $base_url . '/inc/searchform.php",
            success: function(data) {
                $("#searchform").html(data);
            }
        });
    });

    $(document).ready(function() {
        $("#btn-search").click();
    });';
        }
        break;
    case 'save_meta':
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

                $cover_image = $result->cover_image;
                $title = $result->title;
                $author = $result->author;
                $description = $result->description;
                $language = $result->language;
                $identifier = $result->identifier;

                $to_update = array('cover_image' => $cover_image, 'title' => $title, 'author' => $author, 'description' => $description, 'language' => $language, 'identifier' => $identifier);

                $db_con->updateBook($id, $to_update);
                header('Location: index.php');
                exit();

                break;
            default:
                \Bookshelf\Utility\ErrorHandler::throwError('Did not recognize API result.', \Bookshelf\Utility\ErrorLevel::WARNING);
        }
        break;
    default:
        header('Location: upload.php');
}

insertFooter($additional_scripts);
