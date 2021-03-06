<?php

/**
 * Services are globally registered in this file
 */
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\DI\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Mvc\Model\Metadata\Files as MetaDataAdapter;

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
$di['url'] = function () use($config) {
	$url = new UrlResolver();
	$url->setBaseUri($config->application->baseUri);
	
	return $url;
};
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
			'port' => $config->database->port,
			'username' => $config->database->username,
			'password' => $config->database->password,
			'dbname' => $config->database->dbname
	));
	$eventsManager = new \Phalcon\Events\Manager();
	$logger = $di->get('logger');
	$eventsManager->attach('db', function($event, $dbAdapter) use ($logger) {
		if ($event->getType() == 'beforeQuery') {
			$logger->log('[Statement] '.$dbAdapter->getSQLStatement(), \Phalcon\Logger::INFO);
			$logger->log('[Variables] '.implode('; ',$dbAdapter->getSQLVariables()), \Phalcon\Logger::INFO);
		}
	});
	$dbAdapter->setEventsManager($eventsManager);
	return $dbAdapter;
});
/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () use ($config) {
	return new MetaDataAdapter(array(
			'metaDataDir' => $config->application->cacheDir . 'metaData/'
	));
});
/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function() {
	$session = new SessionAdapter();
	$session->start();
	return $session;
});

$di->set('security', function(){
	$security = new \Phalcon\Security();
	//Set the password hashing factor to 12 rounds
	$security->setWorkFactor(12);
	return $security;
}, true);

$di->set('cookies', function() {
	$cookies = new \Phalcon\Http\Response\Cookies();
	$cookies->useEncryption(true);
	return $cookies;
});

$di->set('crypt', function() use ($config) {
	$crypt = new \Phalcon\Crypt();
	$crypt->setKey($config->application->cryptSalt);
	return $crypt;
});

$di->set('auth', function () {
	return new Auth();
});

$di->set('mailer', function () use ($config) {
	switch ($config->email->transport) {
		case 'sendmail':
			break;
		default:
			$transport = Swift_SmtpTransport::newInstance($config->email->host, $config->email->port)
			->setUsername($config->email->user)
			->setPassword($config->email->password);
			break;
	}
	$mailer = Swift_Mailer::newInstance($transport);
	return $mailer;
});