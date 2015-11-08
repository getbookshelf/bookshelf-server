function apiRequest(base_url, action, parameters, success_delegate, error_delegate) {
    var data = { action: action };
    $.extend(data, parameters);

    $.ajax({
        url: base_url + "/api/index.php",
        type: "POST",
        data: data,
        success: success_delegate,
        error: error_delegate
    });
}

function deleteBook(base_url, id) {
    if(window.confirm("Do you really want to delete this book?")) {
        apiRequest(base_url, "deleteBook", { id: id });
        window.location = base_url;
    }
}

