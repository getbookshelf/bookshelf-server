<?php

namespace Bookshelf\DataType;

class BookMetadata {
    public $cover_image;
    public $title;
    public $author;
    public $description;
    public $language; // TODO: Define proper format (i.e. find appropriate ISO guideline)
    public $identifier; // TODO: Decide on a unified identifier to use or implement a DataType\BookIdentifier to save several types of identifiers
    
    function toArray() {
        $result = array();
        if (!empty($cover_image)) $result['cover_image'] = $cover_image;
        if (!empty($title)) $result['title'] = $title;
        if (!empty($author))$result['author'] = $author;
        if (!empty($description)) $result['description'] = $description;
        if (!empty($language)) $result['language'] = $language;
        if (!empty($identifier)) $result['identifier'] = $identifier;
        return $result;
    }

    function toHtmlTableRow($add_radio = false, $api_identifier = '') {
        $result = '<tr>' . ($add_radio ? '<td><input type="radio" name="chosen_book" value="'. $api_identifier .'">' : '');
        $result .= '<td><img src="' . $this->cover_image . '"></td>';
        $result .= '<td>' . $this->title . ' </td >
        <td>' . $this->author . '</td>
        <td>' . $this->description . '</td>
        <td>' . $this->language . '</td>
        <td>' . $this->identifier . '</td>
        </tr>';
        return $result;
    }
}