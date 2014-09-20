<?php
if(!isset($_POST['request'])) {
    echo 'Error: No request.';
    header('Location: index.php');
    exit();
}

$request = $_POST['request'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($request));
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$json_string = curl_exec($ch);
curl_close($ch);

$data_array = json_decode($json_string, true);
?>
<table><thead><td>Cover</td><td>Title</td><td>Author</td><td>Description</td><td>Language</td><td>ISBN-13</td></thead>
<?php
$max_rows = count($data_array['items']) < 3 ? count($data_array['items']) : 3;

for($i = 0; $i < $max_rows; $i++) {
    echo '<tr>
<td><img src="' . $data_array['items'][$i]['volumeInfo']['imageLinks']['smallThumbnail'] .'"></td>
<td>' . $data_array['items'][$i]['volumeInfo']['title'] . '</td>
<td>' . implode(', ', $data_array['items'][$i]['volumeInfo']['authors']) . '</td>
<td>' . $data_array['items'][$i]['volumeInfo']['description'] . '</td>
<td>' . $data_array['items'][$i]['volumeInfo']['language'] . '</td>
<td>' . $data_array['items'][$i]['volumeInfo']['industryIdentifiers'][1]['identifier'] . '</td>
</tr>';
}
?>
</table>