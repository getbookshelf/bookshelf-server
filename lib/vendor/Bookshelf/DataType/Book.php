<?php


namespace Bookshelf\DataType;

use Bookshelf\Core\Configuration;

class Book {
    public $id;
    public $metadata;
    public $uuid = '';
    public $original_name = '';
    public $original_extension = '';

    // every instance of Book MUST have UUID, original name and extension set
    public function __construct($id, $uuid, $original_name, $original_extension, $metadata = null) {
        $this->id = $id;
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

    public function download() {
        $config = new Configuration(true);
        $file = $config->getLibraryDir() . '/' . $this->uuid . $this->original_extension;

        header('Content-Type: ' . finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file));
        header('Content-Disposition: attachment; filename="' . $this->original_name . '.' . $this->original_extension . '"');
        header('Content-Length: ' . filesize($file));
        readfile($file);
    }
}
