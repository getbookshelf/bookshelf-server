<?php

namespace Bookshelf\ExternalApi;

use Bookshelf\DataType;

abstract class ExternalApiRequest {
    protected $results;
    protected $request;
    public $identifier = 'Generic';

    public function __construct() {
        $this->results = new DataType\ExternalApiResult();
    }

    // Request is the default fallback method. Child class will implement request functions specific to the API but still implement this as a default fallback.
    // No limit on the number of results.
    abstract public function request($request);

    abstract public function getBookFromIdentifier($identifier);

    // returns an array of \Bookshelf\DataType\BookMetadata for the different results or an empty array for no results
    public function results(){
        return $this->results;
    }

    public function getRequestString() {
        return $this->request;
    }
}