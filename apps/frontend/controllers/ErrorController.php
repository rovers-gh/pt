<?php

namespace Modules\Frontend\Controllers;

use Phalcon\Http\Response;

class ErrorController extends ControllerBase
{
	public function initialize() {
		parent::initialize();
		$this->tag->appendTitle (" | Error");
	}
	
	public function notFoundAction() {
		// The response is already populated with a 404 Not Found header.
	}
	public function uncaughtExceptionAction() {
		// You need to specify the response header, as it's not automatically set here.
		$this->response->setStatusCode ( 500, 'Internal Server Error' );
	}

}