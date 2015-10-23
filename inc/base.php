<?php
require_once __DIR__ . '/../lib/vendor/autoload.php';
session_start();
require_once __DIR__ . '/auth.php';

if(file_exists(\Bookshelf\Core\Application::ROOT_DIR . '/.maintenance')) {
    echo 'Bookshelf is currently being upgraded. Please check back in a minute.';
    exit;
}

header('Content-type: text/html; charset=utf-8');

require_once __DIR__ . '/functions.php';
