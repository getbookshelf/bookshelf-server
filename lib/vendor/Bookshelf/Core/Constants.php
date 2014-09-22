<?php

namespace Bookshelf\Core;


class Constants {
    public static $root_dir;
    public static $lib_dir;

    public static $version = '0.0.1a'; // TODO: decide on a proper versioning scheme
}

// PHP doesn't allow you to initialize static variables with expressions in the class itself, so we are doing that here

Constants::$root_dir = __DIR__ . '/../../../../';
Constants::$lib_dir = Constants::$root_dir . 'lib';