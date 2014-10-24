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

    public function getQueryString() {
        // TODO: Implement better algorithm to get query string
        $query_string = $this->original_name;
        $strings_to_replace = array('-', '_', '.', ',', ';', ':', '/', '|', '+');
        $query_string = str_replace($strings_to_replace, ' ', $query_string);

        return $query_string;
    }

} 