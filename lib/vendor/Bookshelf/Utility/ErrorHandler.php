<?php

namespace Bookshelf\Utility;

// Unfortunately, PHP doesn't support enums. This (http://php.net/manual/en/class.splenum.php) would work but it requires installing on the target system and I would rather not add additional dependencies
class ErrorLevel {
    // see https://tools.ietf.org/html/rfc5424#section-6.2.1 for log levels
    const EMERGENCY = 0;
    const ALERT = 1;
    const CRITICAL = 2;
    const ERROR = 3;
    const WARNING = 4;
    const NOTICE = 5;
    const INFORMATIONAL = 6;
    const DEBUG = 7;
}

class ErrorHandler {
    public static function throwError($message, $error_level) {
        if(!$_SESSION['errors']) {
            $_SESSION['errors'] = array();
        }

        array_push($_SESSION['errors'], array('message' => $message, 'error_level' => $error_level));
    }

    public static function displayErrors() {
        if(!empty($_SESSION['errors'])) {
            foreach($_SESSION['errors'] as $error => $key) {
                // This might not look very clean at first but keep in mind that this is only a very rudimentary implementation. Later, each error level will have to be handled differently.
                if($key['error_level'] == ErrorLevel::EMERGENCY) {
                    echo '<div class="error emergency">EMERGENCY: ' . $key['message'] . '</div>';
                }
                elseif($key['error_level'] == ErrorLevel::ALERT) {
                    echo '<div class="error alert">ALERT: ' . $key['message'] . '</div>';
                }
                elseif($key['error_level'] == ErrorLevel::CRITICAL) {
                    echo '<div class="error critical">CRITICAL: ' . $key['message'] . '</div>';
                }
                elseif($key['error_level'] == ErrorLevel::ERROR) {
                    echo '<div class="error error">ERROR: ' . $key['message'] . '</div>';
                }
                elseif($key['error_level'] == ErrorLevel::WARNING) {
                    echo '<div class="error warning">WARNING: ' . $key['message'] . '</div>';
                }
                elseif($key['error_level'] == ErrorLevel::NOTICE) {
                    echo '<div class="error notice">NOTICE: ' . $key['message'] . '</div>';
                }
                elseif($key['error_level'] == ErrorLevel::INFORMATIONAL) {
                    echo '<div class="error informational">INFORMATIONAL: ' . $key['message'] . '</div>';
                }
                // TODO: Only show debug message if debugging is enabled in config.php
                elseif($key['error_level'] == ErrorLevel::DEBUG) {
                    echo '<div class="error debug">DEBUG: ' . $key['message'] . '</div>';
                }
            }

            $_SESSION['errors'] = array();
        }
    }
} 