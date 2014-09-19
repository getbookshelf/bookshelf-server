<?php
session_start();
include(__DIR__ . '/inc/auth.php');

include( __DIR__ . '/inc/header.php');
?>
<body>
<h1>Bookshelf</h1>

<a href="index.php">Reload page</a><br>
<a href="logout.php">Logout</a>
</body>
</html>