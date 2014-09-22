<?php
// NOTE: This file only contains a demo implementation, it will likely not be included in the actual software!

session_start();
include(__DIR__ . '/inc/auth.php');

include(__DIR__ . '/inc/header.php');

if(!isset($_POST['request'])) {
    //Error: No request.
    header('Location: index.php');
    exit();
}

$request = $_POST['request'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($request). '&prettyPrint=true');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$json_string = curl_exec($ch);
curl_close($ch);

$data_array = json_decode($json_string, true);

echo '<a href="index.php">back</a><br>';

echo '<br>request: ' . htmlspecialchars($request) . '<br>'; // nope, that is not proper sanitization

$max_rows = count($data_array['items']) < 3 ? count($data_array['items']) : 3;
if($max_rows == 0) { echo 'No results.'; exit(); }

echo '<table><thead><td>Cover</td><td>Title</td><td>Author</td><td>Description</td><td>Language</td><td>Identifier</td></thead>';

for($i = 0; $i < $max_rows; $i++) {
    echo '<tr>
<td><img src="data:image/jpeg;base64,' . base64_encode(file_get_contents($data_array['items'][$i]['volumeInfo']['imageLinks']['smallThumbnail'])) .'"></td>';
if($data_array['items'][$i]['volumeInfo']['subtitle']) {
    echo '<td > ' . $data_array['items'][$i]['volumeInfo']['title'] . ' - ' . $data_array['items'][$i]['volumeInfo']['subtitle'] . ' </td >';
}
else {
    echo '<td > ' . $data_array['items'][$i]['volumeInfo']['title'] . ' </td >';
}
echo '<td>' . implode(', ', $data_array['items'][$i]['volumeInfo']['authors']) . '</td>
<td>' . $data_array['items'][$i]['volumeInfo']['description'] . '</td>
<td>' . $data_array['items'][$i]['volumeInfo']['language'] . '</td>
<td>' . $data_array['items'][$i]['volumeInfo']['industryIdentifiers'][1]['identifier'] . '</td>
</tr>';
}
?>
</table>