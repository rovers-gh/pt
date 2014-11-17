<?php

namespace Modules\Frontend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface {

	private $name = 'frontend';
	/**
	 * Registers the module auto-loader
	 */
	public function registerAutoloaders() {
		$loader = new Loader();

		$loader->registerNamespaces(array (
				'Modules\Frontend\Controllers' => __DIR__ . '/controllers/',
				'Modules\Frontend\Models' => __DIR__ . '/models/',
				'Modules\Frontend\Forms' => __DIR__ . '/forms/',
				'Modules\Frontend\Validators' => __DIR__ . '/validators/',
		));
		
		$loader->register();
	}
	
	/**
	 * Registers the module-only services
	 *
	 * @param Phalcon\DI $di        	
	 */
	public function registerServices($di) {
		
		/**
		 * Read configuration
		 */
		$config = include __DIR__ . "/config/config.php";

		//Registering a dispatcher
		$di->set('dispatcher', function () {
			//Attach a event listener to the dispatcher
			$eventManager = new \Phalcon\Events\Manager();
			$eventManager->attach('dispatch', new \Acl('frontend'));
				
			$dispatcher = new \Phalcon\Mvc\Dispatcher();
			$dispatcher->setEventsManager($eventManager);
			$dispatcher->setDefaultNamespace("Modules\Frontend\Controllers\\");
			return $dispatcher;
		});
		
		/**
		 * Setting up the view component
		 */
		$di ['view'] = function () {
			$view = new View();
			$view->setViewsDir(__DIR__ . '/views/');
			$view->setLayoutsDir('layouts/');
			$view->setTemplateAfter('main');
			
			return $view;
		};
		
		/**
		 * Database connection is created based in the parameters defined in the configuration file
		 */
// 		$di ['db'] = function () use($config) {
// 			$dbclass = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
// 			$dbAdapter = new $dbclass(array (
// 					"host" => $config->database->host,
// 					"port" => $config->database->port,
// 					"username" => $config->database->username,
// 					"password" => $config->database->password,
// 					"dbname" => $config->database->name 
// 			));
// 			$eventsManager = new \Phalcon\Events\Manager();
// 			$logger = $di->get('logger');
// 			$eventsManager->attach('db', function ($event, $dbAdapter) use($logger) {
// 				if ($event->getType() == 'beforeQuery') {
// 					$logger->log('[Statement] ' . $dbAdapter->getSQLStatement(), \Phalcon\Logger::INFO);
// 					$logger->log('[Variables] ' . implode('; ', $dbAdapter->getSQLVariables()), \Phalcon\Logger::INFO);
// 				}
// 			});
// 			$dbAdapter->setEventsManager($eventsManager);
// 			return $dbAdapter;
// 		};
	}
}
