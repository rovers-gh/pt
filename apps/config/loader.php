<?php
// Use composer autoloader to load vendor classes
require_once BASE_PATH . '/vendor/autoload.php';

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(array (
		APP_PATH . '/library/' 
));

$loader->register();
