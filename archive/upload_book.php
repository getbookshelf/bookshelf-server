<?php
// NOTE: This file only contains a demo implementation, it will likely not be included in the actual software!
use \Bookshelf\DataIo\FileManager;

require_once __DIR__ . '/inc/base.php';
insertHeader();
echo '<a href="../index.php">back</a><br>';

if(isset($_FILES)) {
    $file_manager = new FileManager();
    $uploaded_book_id = $file_manager->uploadBook($_FILES);

    echo '<br>Upload successful. ID of the new book: ' . $uploaded_book_id;

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
    echo '<br><a href="#" onclick="post(\'search.php\', {id: \'' . $uploaded_book_id . '\'})">Set metadata</a>';
}
else {
    \Bookshelf\Utility\ErrorHandler::throwError('No file to upload.', \Bookshelf\Utility\ErrorLevel::ERROR);
}
insertFooter();
