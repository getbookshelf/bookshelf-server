<?php

namespace Bookshelf\DataType;

class BookMetadata {
    public $cover_image;
    public $title;
    public $author;
    public $description;
    public $language; // TODO: Define proper format (i.e. find appropriate ISO guideline)
    public $identifier; // TODO: Decide on a unified identifier to use or implement a DataType\BookIdentifier to save several types of identifiers
} 