<?php

namespace Bookshelf\DataType;

class ExternalApiResult {
    private result_collection = array();
    
    /* 
        @param metadata BookMetadata metadata to add to the result
    */
    public function addMetadata($metadata) {
        array_push($this->result_collection, $result);
    }
    
    public function __toString() {
        foreach ( $this->result_collection as $metadata ) {
            echo $metadata->title; //TODO: More advanced printout.
        }
    }
} 