<?php

namespace Bookshelf\DataType;

class ExternalApiResult {
    private $result_collection = array();
    
    /* 
        @param metadata BookMetadata metadata to add to the result
    */
    public function addMetadata($metadata) {
        array_push($this->result_collection, $metadata);
    }
    
    public function __toString() {
        $return_string = '';
        foreach($this->result_collection as $metadata) {
            $return_string .= $metadata->title; // TODO: More advanced printout.
        }

        return $return_string;
    }
} 