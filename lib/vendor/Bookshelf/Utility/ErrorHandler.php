<?php

namespace Bookshelf\Utility;

// Unfortunately, PHP doesn't support enums. This (http://php.net/manual/en/class.splenum.php) would work but it requires installing on the target system and I would rather not add additional dependencies
use Bookshelf\Core\Configuration;

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
    // TODO: Handle different error levels differently, e.g.: for levels 3 (error) and above, automatically set header('Location: index.php'); and exit();
    public static function throwError($message, $error_level) {
        if(!$_SESSION['errors']) {
            $_SESSION['errors'] = array();
        }

        array_push($_SESSION['errors'], array('message' => $message, 'error_level' => $error_level));
    }

    // If displayErrors() is called at the bottom of a page, we don't want to output anything as straight HTML as there might be a redirect that would cause the user not to see the message
    public static function displayErrors($bottom = false) {
        if(!empty($_SESSION['errors'])) {
            foreach($_SESSION['errors'] as $error) {
                if($error['error_level'] == ErrorLevel::EMERGENCY) {
                    echo '<script>window.alert("EMERGENCY: ' . $error['message'] . '");</script>';
                }
                elseif($error['error_level'] == ErrorLevel::ALERT) {
                    echo '<script>window.alert("ALERT: ' . $error['message'] . '");</script>';
                }
                elseif($error['error_level'] == ErrorLevel::CRITICAL) {
                    echo '<script>window.alert("CRITICAL: ' . $error['message'] . '");</script>';
                }
                elseif($error['error_level'] == ErrorLevel::ERROR) {
                    echo '<script>window.alert("ERROR: ' . $error['message'] . '");</script>';
                }
                elseif($error['error_level'] == ErrorLevel::WARNING) {
                    echo '<script>window.alert("WARNING: ' . $error['message'] . '");</script>';
                }
                elseif($error['error_level'] == ErrorLevel::NOTICE) {
                    if(!$bottom) {
                        echo '<div class="error notice">NOTICE: ' . $error['message'] . '</div>';
                    }
                }
                elseif($error['error_level'] == ErrorLevel::INFORMATIONAL) {
                    if(!$bottom) {
                        echo '<div class="error informational">INFORMATIONAL: ' . $error['message'] . '</div>';
                    }
                }
                elseif($error['error_level'] == ErrorLevel::DEBUG) {
                    $config = new Configuration();
                    if($config->getDebuggingEnabled()) {
                        if(!$bottom) {
                            echo '<div class="error debug">DEBUG: ' . $error['message'] . '</div>';
                        }
                    }
                }

                if(!$bottom) {
                    // remove item from array, see http://stackoverflow.com/a/2449093
                    if(($key = array_search($error, $_SESSION['errors'])) !== false) {
                        unset($_SESSION['errors'][$key]);
                    }
                }
            }
        }
    }
}
