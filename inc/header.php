<?php
    require_once __DIR__ . '/../lib/vendor/autoload.php';
    header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Bookshelf - eBook Administration Interface</title>
	</head>
    <body>
    <div id="wrapper">
    <?php
        \Bookshelf\Utility\ErrorHandler::displayErrors();