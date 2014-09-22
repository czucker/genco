<?php

//**** This file needs to be included from a file that has access to "wp-load.php" ****
function eMember_log_debug($message, $success, $end = false) {
    global $emember_config;
    $emember_config = Emember_Config::getInstance();
    $debug_enabled = false;
    if ($emember_config->getValue('eMember_enable_debug') == 1) {
        $debug_enabled = true;
    }

    if (!$debug_enabled)
        return; //Debug is not enabled

    $debug_log_file_name = dirname(__FILE__) . '/eMember_debug.log';

    // Timestamp
    $text = '[' . date('m/d/Y g:i A') . '] - ' . (($success) ? 'SUCCESS :' : 'FAILURE :') . $message . "\n";
    if ($end) {
        $text .= "\n------------------------------------------------------------------\n\n";
    }
    // Write to log
    $fp = fopen($debug_log_file_name, 'a');
    fwrite($fp, $text);
    fclose($fp);  // close file
}

function eMember_log_debug_array($array_to_write, $success, $end = false, $debug_log_file_name = '') {
    global $emember_config;
    $emember_config = Emember_Config::getInstance();
    $debug_enabled = false;
    if ($emember_config->getValue('eMember_enable_debug') == 1) {
        $debug_enabled = true;
    }
    if (!$debug_enabled)
        return;
    // Timestamp
    $text = '[' . date('m/d/Y g:i A') . '] - ' . (($success) ? 'SUCCESS :' : 'FAILURE :') . "\n";
    ob_start();
    print_r($array_to_write);
    $var = ob_get_contents();
    ob_end_clean();
    $text .= $var;

    if ($end) {
        $text .= "\n------------------------------------------------------------------\n\n";
    }

    if (empty($debug_log_file_name)) {
        $debug_log_file_name = dirname(__FILE__) . '/eMember_debug.log';
    }
    // Write to log
    $fp = fopen($debug_log_file_name, 'a');
    fwrite($fp, $text);
    fclose($fp);  // close file
}

function eMember_log_cronjob_debug($message, $success, $end = false) {
    global $emember_config;
    $emember_config = Emember_Config::getInstance();
    $debug_enabled = false;
    if ($emember_config->getValue('eMember_enable_debug') == 1) {
        $debug_enabled = true;
    }

    if (!$debug_enabled)
        return; //Debug is not enabled

    $debug_log_file_name = dirname(__FILE__) . '/eMember_debug_cronjob.log';

    // Timestamp
    $text = '[' . date('m/d/Y g:i A') . '] - ' . (($success) ? 'SUCCESS :' : 'FAILURE :') . $message . "\n";
    if ($end) {
        $text .= "\n------------------------------------------------------------------\n\n";
    }
    // Write to log
    $fp = fopen($debug_log_file_name, 'a');
    fwrite($fp, $text);
    fclose($fp);  // close file
}

function wp_emember_reset_log_files() {
    $log_reset = true;
    $emember_logfile_list = array(
        WP_EMEMBER_PATH . "/eMember_debug.log",
        WP_EMEMBER_PATH . "/eMember_debug_cronjob.log",
        WP_EMEMBER_PATH . "/ipn/ipn_handle_debug_eMember.log"
    );

    foreach ($emember_logfile_list as $logfile) {
        $text = '[' . date('m/d/Y g:i A') . '] - SUCCESS : Log file reset';
        $text .= "\n------------------------------------------------------------------\n\n";
        $fp = fopen($logfile, 'w');
        if ($fp != FALSE) {
            @fwrite($fp, $text);
            @fclose($fp);
        } else {
            $log_reset = false;
        }
    }
    return $log_reset;
}
