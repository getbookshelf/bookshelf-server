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

    // TODO: Optimize displaying of errors. Currently, they are only displayed on a new request. Possible option: Run displayErrors() at the bottom of each page (instead of at the top) and display errors either as JS alert or as error box (=> CSS to make it appear on top of content)
    public static function displayErrors() {
        if(!empty($_SESSION['errors'])) {
            foreach($_SESSION['errors'] as $error) {
                if($error['error_level'] == ErrorLevel::EMERGENCY) {
                    //echo '<div class="emergency">EMERGENCY: ' . $error['message'] . '</div>';
                    echo '<script>window.alert("EMERGENCY: ' . $error['message'] . '");</script>';
                }
                elseif($error['error_level'] == ErrorLevel::ALERT) {
                    //echo '<div class="alert">ALERT: ' . $error['message'] . '</div>';
                    echo '<script>window.alert("ALERT: ' . $error['message'] . '");</script>';
                }
                elseif($error['error_level'] == ErrorLevel::CRITICAL) {
                    //echo '<div class="error critical">CRITICAL: ' . $error['message'] . '</div>';
                    echo '<script>window.alert("CRITICAL: ' . $error['message'] . '");</script>';
                }
                elseif($error['error_level'] == ErrorLevel::ERROR) {
                    //echo '<div class="error error">ERROR: ' . $error['message'] . '</div>';
                    echo '<script>window.alert("ERROR: ' . $error['message'] . '");</script>';
                }
                elseif($error['error_level'] == ErrorLevel::WARNING) {
                    //echo '<div class="error warning">WARNING: ' . $error['message'] . '</div>';
                    echo '<script>window.alert("WARNING: ' . $error['message'] . '");</script>';
                }
                elseif($error['error_level'] == ErrorLevel::NOTICE) {
                    echo '<div class="error notice">NOTICE: ' . $error['message'] . '</div>';
                    //echo '<script>window.alert("NOTICE: ' . $error['message'] . '");</script>';
                }
                elseif($error['error_level'] == ErrorLevel::INFORMATIONAL) {
                    echo '<div class="error informational">INFORMATIONAL: ' . $error['message'] . '</div>';
                    //echo '<script>window.alert("INFORMATIONAL: ' . $error['message'] . '");</script>';
                }
                elseif($error['error_level'] == ErrorLevel::DEBUG) {
                    $config = new Configuration();
                    if($config->getDebuggingEnabled()) {
                        echo '<div class="error debug">DEBUG: ' . $error['message'] . '</div>';
                        //echo '<script>window.alert("DEBUG: ' . $error['message'] . '");</script>';
                    }
                }
            }

            $_SESSION['errors'] = array();
        }
    }
}
