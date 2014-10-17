<?php


namespace Bookshelf\DataType;


class Book {
    public $metadata;
    public $uuid = "";
    public $original_name = "";
    public $original_extension = "";

    public function __construct() {
        $this->metadata = new BookMetadata();
    }

} 