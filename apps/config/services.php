<?php

/**
 * Services are globally registered in this file
 */
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\DI\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * Register the global configuration as config
 */
$di->set('config', $config);

/**
 * Registering a router
 */
$di ['router'] = function () {
	
	$router = new Router();
	
	$router->setDefaultModule("frontend");
	$router->setDefaultNamespace("Modules\Frontend\Controllers");
	
	return $router;
};

/**
 * The URL component is used to generate all kind of urls in the application
 */
// $di['url'] = function () {
// $url = new UrlResolver();
// $url->setBaseUri('/modules/');

// return $url;
// };
$di->set('logger', function () use($config) {
	return new \Phalcon\Logger\Adapter\File($config->application->logDir . 'error-' . date('Ymd') . '.log');
});
/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config, $di) {
	$dbclass = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
	$dbAdapter = new $dbclass(array(
			'host' => $config->database->host,
			'username' => $config->database->username,
			'password' => $config->database->password,
			'dbname' => $config->database->dbname
	));
	$eventsManager = new \Phalcon\Events\Manager();
	$logger = $di->get('logger');
	$eventsManager->attach('db', function($event, $dbAdapter) use ($logger) {
		if ($event->getType() == 'beforeQuery') {
			$logger->log('[Statement] '.$dbAdapter->getSQLStatement(), \Phalcon\Logger::INFO);
			// 			$logger->log('[BindTypes] '.implode('; ',$dbAdapter->getSQLBindTypes()), \Phalcon\Logger::INFO);
			$logger->log('[Variables] '.implode('; ',$dbAdapter->getSQLVariables()), \Phalcon\Logger::INFO);
		}
	});
	$dbAdapter->setEventsManager($eventsManager);
	return $dbAdapter;
});
/**
 * Start the session the first time some component request the session service
 */
// $di ['session'] = function () {
// 	$session = new SessionAdapter();
// 	$session->start();
	
// 	return $session;
// };
$di->setShared('session', function() {
	$session = new Phalcon\Session\Adapter\Files();
	$session->start();
	return $session;
});

$di->set('security', function(){

	$security = new Phalcon\Security();

	//Set the password hashing factor to 12 rounds
	$security->setWorkFactor(12);

	return $security;
}, true);
