<?php
session_start();
include(__DIR__ . '/inc/auth.php');

include( __DIR__ . '/inc/header.php');
?>
<body>
<div id="wrapper">
    <h1>Bookshelf</h1>

    <p>
        <h2>Search</h2>
        <form method="post" action="search.php">
            <input type="text" name="request" id="request">
            <input type="submit">
        </form>
    </p>

    <a href="index.php">Reload page</a><br>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>