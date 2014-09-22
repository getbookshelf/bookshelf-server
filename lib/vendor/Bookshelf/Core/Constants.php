<?php

namespace Bookshelf\Core;


class Constants {
    public static $ROOT_DIR;
    public static $LIB_DIR;

    public static $VERSION-TEXT = '0.0.1a'; // TODO: decide on a proper versioning scheme
    public static $VERSION-CODE = 1;
}

// PHP doesn't allow you to initialize static variables with expressions in the class itself, so we are doing that here

Constants::$ROOT_DIR = __DIR__ . '/../../../../';
Constants::$LIB_DIR = Constants::$ROOT_DIR . 'lib';