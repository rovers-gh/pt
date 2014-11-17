<?php
return new \Phalcon\Config(array (
		'database' => array (
				'adapter' => 'Mysql',
				'host' => 'localhost',
				'port' => '3306',
				'username' => 'root',
				'password' => '',
				'dbname' => 'website' 
		),
		'application' => array (
				'controllersDir' => __DIR__ . '/../controllers/',
				'modelsDir' => __DIR__ . '/../models/',
				'viewsDir' => __DIR__ . '/../views/',
				'baseUri' => '/' 
		) 
));
