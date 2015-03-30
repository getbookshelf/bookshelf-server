<?php
require_once __DIR__ . '/inc/base.php';
insertHeader();

$current_step = $_POST['step'];
$additional_scripts = '';

switch($current_step) {
    case 'update':
        $db_con = new \Bookshelf\DataIo\DatabaseConnection();

        $id = $_POST['id'];
        $cover_image = $_POST['cover_image'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $description = $_POST['description'];
        $language = $_POST['language'];
        $identifier = $_POST['identifier'];

        $to_update = array('cover_image' => $cover_image, 'title' => $title, 'author' => $author, 'description' => $description, 'language' => $language, 'identifier' => $identifier);

        $db_con->updateBook($id, $to_update);
        header('Location: book.php?id=' . $id);
        exit();
        break;
    default:
        $id = $_GET['id'];
        if(!empty($id)) {
            $lib_man = new \Bookshelf\Core\LibraryManager();
            $book = $lib_man->getBookById($id);

            echo '<h1>Edit book</h1>';
            echo '<p>You are editing the metadata for the file <span class="italic">' . $book->original_name . '.' . $book->original_extension . '</span>:</p>';
            echo '<p><form action="#" method="post">';
            echo '<input id="id" name="id" type="hidden" value="' . $id . '">';
            echo '<input id="step" name="step" type="hidden" value="update">';
            echo 'Title: <input id="title" name="title" type="text" value="' . $book->metadata->title . '"><br>';
            echo 'Author(s): <input id="author" name="author" type="text" value="' . $book->metadata->author . '"><br>';
            echo 'Language: <input id="language" name="language" type="text" value="' . $book->metadata->language . '"><br>';
            echo 'ISBN-13: <input id="identifier" name="identifier" type="text" value="' . $book->metadata->identifier . '"><br>';
            echo 'Description:<br><textarea id="description" name="description">' . $book->metadata->description . '</textarea><br>';
            echo 'Cover image: <input id="img_upload" name="img_upload" type="file"><br>';
            echo '<input id="cover_image" name="cover_image" type="hidden" value="' . $book->metadata->cover_image . '">';
            echo '<input type="submit" value="Edit metadata">';
            echo '</form></p>';

            $additional_scripts = '
            function dataUrlFromImage(event) {
                var files = event.target.files;
                var reader = new FileReader();

                reader.onload = (function(file) {
                    return function(e) {
                        $("#cover_image").val(e.target.result);
                    };
                })(files[0]);

                reader.readAsDataURL(files[0]);
            }

            document.getElementById("img_upload").addEventListener("change", dataUrlFromImage, false);
            ';
        }
        else {
            \Bookshelf\Utility\ErrorHandler::throwError('No book selected.', \Bookshelf\Utility\ErrorLevel::ERROR);
            header('Location: index.php');
            exit();
        }
}

insertFooter($additional_scripts);
