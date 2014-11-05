<?php


namespace Bookshelf\DataType;


class Book {
    public $metadata;
    public $uuid = '';
    public $original_name = '';
    public $original_extension = '';

    // every instance of Book MUST have UUID, original name and extension set
    public function __construct($uuid, $original_name, $original_extension, $metadata = null) {
        $this->uuid = $uuid;
        $this->original_name = $original_name;
        $this->original_extension = $original_extension;

        $this->metadata = $metadata ? $metadata : new BookMetadata();
    }

    public function getQueryString() {
        // TODO: Implement better algorithm to get query string
        $query_string = $this->original_name;
        $strings_to_replace = array('-', '_', '.', ',', ';', ':', '/', '|', '+');
        $query_string = str_replace($strings_to_replace, ' ', $query_string);

        return $query_string;
    }
} 