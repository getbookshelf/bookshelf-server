<?php

namespace Bookshelf\Core;

// PHP doesn't allow you to use expressions in the definition of const, therefore we have to use this
// see: http://stackoverflow.com/a/2787565
define('rootdir', __DIR__ . '/../../../..');
define('libdir', Application::ROOT_DIR . '/lib');
define('tmpdir', Application::ROOT_DIR . '/cache');

class Application {
    const ROOT_DIR = rootdir;
    const LIB_DIR = libdir;
    const TMP_DIR = tmpdir;

    const VERSION_TEXT = '0.1.0-alpha';
    const VERSION_CODE = 1;

    const UPDATE_VERSION_INFO_URL = 'https://raw.githubusercontent.com/getbookshelf/bookshelf-updates/master/version';

    public static function lockForMaintenance() {
        touch(Application::ROOT_DIR . '/.maintenance');
    }

    public static function unlockFromMaintenance() {
        unlink(Application::ROOT_DIR . '/.maintenance');
    }
}
