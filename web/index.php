<?php
error_reporting(E_ALL);

// try {
	define('DS', DIRECTORY_SEPARATOR);
	define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));
	define('APP_PATH', BASE_PATH . '/apps');
	
	/**
	 * Read the configuration
	 */
	$config = include APP_PATH . '/config/config.php';
	if ($config->application->debug === 1) {
		(new \Phalcon\Debug())->listen();
	}
	/**
	 * Read auto-loader
	 */
	include APP_PATH . '/config/loader.php';
	/**
	 * Include services
	 */
	require APP_PATH . '/config/services.php';
	
	/**
	 * Handle the request
	 */
	$application = new \Phalcon\Mvc\Application($di);
	
	/**
	 * Include modules
	 */
	require APP_PATH . '/config/modules.php';
	
	echo $application->handle()->getContent();
// } catch ( Exception $e ) {
// 	echo $e->getMessage();
// 	$logger = $di->get('logger');
// 	$logger->log($e->getMessage(), \Phalcon\Logger::ERROR);
// 	$logger->log($e->getTraceAsString(), \Phalcon\Logger::ERROR);
// }
// // try {
	
// 	/**
// 	 * Define some useful constants
// 	 */
// 	define('DS', DIRECTORY_SEPARATOR);
// 	define('BASE_PATH', realpath(dirname(__FILE__).'/../'));
// 	define('APP_PATH', BASE_PATH.'/apps');
	

// 	/**
// 	 * Read the configuration
// 	 */
// 	$config = include APP_PATH . '/config/config.php';
// 	if($config->application->debug === 1){
// 		(new \Phalcon\Debug())->listen();
// 	}
// 	/**
// 	 * Read auto-loader
// 	 */
// 	include APP_PATH . '/config/loader.php';
// 	/**
// 	 * Read services
// 	 */
// 	require APP_PATH . '/config/services.php';

// 	/**
// 	 * Handle the request
// 	 */
// 	$application = new \Phalcon\Mvc\Application();

// 	$application->setDI($di);
// // 	$modules = array ();
// // 	foreach($config->application->modules as $module){
// // 		$modules[$module] = array(
// // 				'className' => 'Modules\\'.ucfirst($module).'\Module',
// // 				'path' => APP_PATH.'/'.$module.'/Module.php' 
// // 		);
// // 	}
// // 	$application->registerModules($modules);
// 	/**
// 	 * Register application modules
// 	 */
// 	$application->registerModules(array(
// 			'frontend' => array(
// 					'className' => 'Modules\Frontend\Module',
// 					'path' => '../apps/frontend/Module.php'
// 			),
// 			'backend' => array(
// 					'className' => 'Modules\Backend\Module',
// 					'path' => '../apps/backend/Module.php'
// 			)
// 	));
// 	echo $application->handle()->getContent();
// // } catch (Phalcon\Exception $e) {
// // 	echo get_class($e), ": ", $e->getMessage(), "<br>";
// // 	echo " File=", $e->getFile(), "\n";
// // 	echo " Line=", $e->getLine(), "\n";
// // 	echo $e->getTraceAsString();
// // 	$application->logger->log($e->getMessage(), \Phalcon\Logger::ERROR);
// // 	$application->logger->log(" File=".$e->getFile(), \Phalcon\Logger::ERROR);
// // 	$application->logger->log(" Line=".$e->getLine(), \Phalcon\Logger::ERROR);
// // 	$application->logger->log($e->getTraceAsString(), \Phalcon\Logger::ERROR);
// // } catch (PDOException $e){
// // 	echo $e->getMessage(), '<br>';
// // 	echo nl2br(htmlentities($e->getTraceAsString()));
// // }
