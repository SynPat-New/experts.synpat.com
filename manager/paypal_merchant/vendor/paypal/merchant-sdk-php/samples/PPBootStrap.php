<?php
/**
 * Include this file in your application. This file sets up the required classloader based on
* whether you used composer or the custom installer.
*/

//
require_once 'Configuration.php';
/*
 * @constant PP_CONFIG_PATH required if credentoal and configuration is to be used from a file
* Let the SDK know where the sdk_config.ini file resides.
*/
//define('PP_CONFIG_PATH', dirname(__FILE__));

/*
 * use autoloader
*/
$fileAutoload =  $_SERVER['DOCUMENT_ROOT'] . '/paypal_merchant/vendor/autoload.php';
if(file_exists($fileAutoload)) {
/*require WP_PLUGIN_DIR. '/wp-user-manager/includes/lib/lib_paypal_merchant/vendor/autoload.php';*/
require $fileAutoload;
} else {
require 'PPAutoloader.php';
    PPAutoloader::register();
}