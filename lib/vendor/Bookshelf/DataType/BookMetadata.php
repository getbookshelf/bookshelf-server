<?php

namespace Bookshelf\DataType;

class BookMetadata {
    public $cover_image;
    public $title;
    public $author;
    public $description;
    public $tags = array();
    public $categories = array();
    public $language;
    public $identifier;

    public function toArray() {
        $result = array();
        if(!empty($this->cover_image)) $result['cover_image'] = $this->cover_image;
        if(!empty($this->title)) $result['title'] = $this->title;
        if(!empty($this->author))$result['author'] = $this->author;
        if(!empty($this->description)) $result['description'] = $this->description;
        if(!empty($this->tags)) $result['tags'] = $this->tags;
        if(!empty($this->categories)) $result['categories'] = $this->categories;
        if(!empty($this->language)) $result['language'] = $this->language;
        if(!empty($this->identifier)) $result['identifier'] = $this->identifier;
        return $result;
    }

    // TODO: Doesn't include tags and categories. However, IMHO it should be obsolete anyway. Can this be removed?
    public function toHtmlTableRow($add_button = '', $api_identifier = '', $database_id = '') {
        $result = '<tr>' . ($add_button != '' ? '<td><input type="' . $add_button . '" name="chosen_book[]" value="'. $api_identifier .'">' : '');
        $result .= '<td><img src="' . $this->cover_image . '"></td>';
        $result .= '<td>' . (empty($database_id) ? $this->title : '<a href="download.php?id=' . $database_id .'">' . $this->title .'</a>')  . ' </td >
        <td>' . $this->author . '</td>
        <td>' . $this->description . '</td>
        <td>' . $this->language . '</td>
        <td>' . $this->identifier . '</td>
        </tr>';
        return $result;
    }
}
