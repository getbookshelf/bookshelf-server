<?php
require_once __DIR__ . '/../lib/vendor/autoload.php';
session_start();
require_once __DIR__ . '/auth.php';

header('Content-type: text/html; charset=utf-8');

require_once __DIR__ . '/functions.php';
