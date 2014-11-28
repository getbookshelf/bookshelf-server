<?php

namespace Bookshelf\DataType;


class ApiRequest {
    public $action = '';

    // $post is the PHP $_POST
    public function __construct($post) {
        $this->action = strtolower($post['action']);
        $this->book_meta = new BookMetadata();
        $this->book_meta->author = $post['meta_author'];
        $this->book_meta->cover_image = $post['meta_cover_image'];
        $this->book_meta->description = $post['meta_description'];
        $this->book_meta->identifier = $post['meta_identifier'];
        $this->book_meta->language = $post['meta_language'];
        $this->book_meta->title = $post['meta_title'];

    }
} 