<?php

use \Phalcon\Events\Event;
use \Phalcon\Mvc\Dispatcher;

class Acl extends \Phalcon\Mvc\User\Component
{

	protected $_module;

	public function __construct($module)
	{
		$this->_module = $module;
	}
	public function beforeException(Event $event, Dispatcher $dispatcher, $exception)
	{
		$this->logger->log($exception->getMessage(), \Phalcon\Logger::ERROR);
		$this->logger->log($exception->getTraceAsString(), \Phalcon\Logger::ERROR);
		if ($this->config->application->debug === 0) {
			// Handle 404 exceptions
			switch ($exception->getCode ()) {
				case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND :
				case Dispatcher::EXCEPTION_ACTION_NOT_FOUND :
					$dispatcher->forward ( array (
							'controller' => 'error',
							'action' => 'notFound' 
					) );
					return false;
					break;
				default :
					$dispatcher->forward ( array (
							'controller' => 'error',
							'action' => 'uncaughtException' 
					) );
					return false;
					break;
			}
		}
	}
	public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
	{
	}

}