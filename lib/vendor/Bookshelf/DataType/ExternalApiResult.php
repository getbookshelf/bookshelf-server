<?php

namespace Bookshelf\DataType;

class ExternalApiResult {
    private $result_collection = array();
    
    /* 
        @param metadata BookMetadata metadata to add to the result
    */
    public function addMetadata($metadata, $api_identifier) {
        $result = array('metadata' => $metadata, 'api_identifier' => $api_identifier);
        array_push($this->result_collection, $result);
    }
    
    public function __toString() {
        $return_string = '';
        foreach($this->result_collection as $metadata) {
            $return_string .= $metadata->title; // TODO: More advanced printout.
        }

        return $return_string;
    }

    public function toHtmlTable($add_radio = false, $max_rows = 3) {
        $result = '<table><thead>' . ($add_radio ? '<td></td>' : '') . '<td>Cover</td><td>Title</td><td>Author</td><td>Description</td><td>Language</td><td>Identifier</td></thead>';

        for($i = 0; $i < $max_rows; $i++) {
            //TODO
        }

        $result .= '</table>';
        return $result;
    }
}
