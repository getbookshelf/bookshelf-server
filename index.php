<?php
require __DIR__ . '/lib/vendor/autoload.php';
session_start();
include(__DIR__ . '/inc/auth.php');

include( __DIR__ . '/inc/header.php');

$lib_man = new \Bookshelf\Core\LibraryManager();
$books = $lib_man->listBooks();
?>
    <div id="user-menu">
        Hi there, username.

        <p>
            <a href="#">Add new book</a><br>
            <a href="#">Settings</a>
        </p>
    </div>
<?php

foreach($books as $book) {
    echo '<a href="book.php?id=' . $lib_man->getBook('uuid', $book->uuid, true) . '"><img class="book" src="' . $book->metadata->cover_image . '"></a>';
}

include( __DIR__ . '/inc/footer.php');

/* Old code archived for now, will be deleted ASAP though
    <h1>Bookshelf</h1>

    <p>
        <h2>Search</h2>
        <form method="post" action="search.php">
            <input type="text" name="request" id="request">
            <input type="submit">
        </form>
    </p>

    <p>
        <h2>Show the library</h2>
        <p><a href="list_books.php">List Books</a></p>
    </p>

    <p>
        <h2>Upload eBook</h2>
        <form enctype="multipart/form-data" action="upload_book.php" method="POST">
            <input name="file" type="file" /><br>
            <input type="submit" value="Upload" />
        </form>
    </p>

    <a href="index.php">Reload page</a><br>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>
*/
