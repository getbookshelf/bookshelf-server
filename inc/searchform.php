<?php
require_once __DIR__ . '/base.php';

$id = $_POST['id'];
$query_string = $_POST['query_string'];

$gb_request = new \Bookshelf\ExternalApi\GoogleBooksApiRequest();
$gb_request->volumeSearch($query_string, 3);

echo '<form method="post" action="#">';
echo '<input type="hidden" name="id" value="' . $id . '">';
echo '<input type="hidden" name="step" value="save_meta">';
echo $gb_request->results()->toHtmlTable('radio');
echo '<input type="submit" value="Set metadata">';
echo '</form>';
