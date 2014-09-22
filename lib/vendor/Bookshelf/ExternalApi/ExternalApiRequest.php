<?php

namespace Bookshelf\ExternalApi;


abstract class ExternalApiRequest {
    protected  $results = array();
    protected  $request;

    public function __construct() {

    }

    // Request is the default fallback method. Child class will implement request functions specific to the API but still implement this as a default fallback.
    // No limit on the number of results.
    abstract public function request($request);

    // returns an array of \Bookshelf\DataType\BookMetadata for the different results or an empty array for no results
    public function results(){
        return $this->results;
    }

    public function get_request_string() {
        return $this->request;
    }
}
