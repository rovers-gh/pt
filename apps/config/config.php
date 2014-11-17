<?php
return new \Phalcon\Config(array(
		'database' => array(
				'adapter' => 'Mysql',
				'host' => 'localhost',
				'username' => 'root',
				'password' => '',
				'dbname' => 'website' 
		),
		'application' => array(
				'dirs' => array('controllers','models','forms','views','validators','library','plugins'),
				'modules' => array('frontend','backend'),
				'libraryDir' => APP_PATH . '/library/',
				'pluginsDir' => APP_PATH . '/plugins/',
				'cacheDir' => APP_PATH . '/cache/',
				'logDir' => APP_PATH . '/logs/',
				'baseUri' => '',
				'debug' => 1
		)
) );
