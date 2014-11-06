<?php
require __DIR__ . '/lib/vendor/autoload.php';
session_start();
include(__DIR__ . '/inc/auth.php');

include( __DIR__ . '/inc/header.php');
?>
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
<?php
include( __DIR__ . '/inc/footer.php');
