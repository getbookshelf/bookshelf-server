<?php

namespace Bookshelf\DataType;

class ExternalApiResult {
    private $result_collection = array();

    public function addMetadata($metadata, $api_identifier) {
        $result = array('metadata' => $metadata, 'api_identifier' => $api_identifier);
        array_push($this->result_collection, $result);
    }

    // TODO: Do we need that anywhere?
    public function __toString() {
        $return_string = '';
        foreach($this->result_collection as $metadata) {
            $return_string .= $metadata->title; // TODO: More advanced printout.
        }

        return $return_string;
    }

    public function toHtmlTable($add_radio = false, $max_rows = 3) {
        $result = '<table><thead>' . ($add_radio ? '<td></td>' : '') . '<td>Cover</td><td>Title</td><td>Author</td><td>Description</td><td>Language</td><td>Identifier</td></thead>';
        $max_rows = ($max_rows > count($this->result_collection) ? count($this->result_collection) : $max_rows);

        for($i = 0; $i < $max_rows; $i++) {
            $result .= $this->result_collection[$i]['metadata']->toHtmlTableRow($add_radio, $this->result_collection[$i]['api_identifier']);
        }

        $result .= '</table>';
        return $result;
    }

    public function getResults() {
        return $this->result_collection;
    }
}
