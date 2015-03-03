<?php
require_once __DIR__ . '/../lib/vendor/autoload.php';
header('Content-type: text/html; charset=utf-8');
// TODO: Make title variable
// TODO: Navigation
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bookshelf</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div id="wrapper" name="wrapper">
    <header>
        <div class="container">
            <span id="logo" name="logo"><a href="index.php">Bookshelf</a></span>
            <nav>
                <span class="nav-item"><a href="#">All</a></span>
                <span class="nav-item"><a href="#">Authors</a></span>
                <span class="nav-item"><a href="#">Languages</a></span>
                <span class="nav-item"><a href="#">Something Else</a></span>
                <input name="search-bar" type="text" placeholder="Search...">
            </nav>
        </div>
    </header>
    <div id="main" name="main">
        <div class="container">
<?php
\Bookshelf\Utility\ErrorHandler::displayErrors();
