<?php
// NOTE: This file only contains a demo implementation, it will likely not be included in the actual software!

session_start();
include(__DIR__ . '/inc/auth.php');

include(__DIR__ . '/inc/header.php');
echo '<a href="index.php">back</a><br>';

// TODO: make sure we don't override existing files
$filename = '/var/www/bookshelf/library/' . basename($_FILES['file']['name']);

if (move_uploaded_file($_FILES['file']['tmp_name'], $filename)) {
    echo 'upload successful.';
}
else {
    echo 'could not upload to ' . $filename;
    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';
    exit();
}

$query_string = pathinfo($filename, PATHINFO_FILENAME); // filename without extension
$query_string = str_replace('-', ' ', $query_string);
$query_string = str_replace('_', ' ', $query_string);

echo '<br>query string: ' . $query_string;

// source: http://stackoverflow.com/a/133997
echo '<script>
function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}
</script>';
echo '<br><a href="#" onclick="post(\'search.php\', {request: \'' . $query_string . '\'})">send to search.php</a>';