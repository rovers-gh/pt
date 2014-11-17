<?php

namespace Modules\Frontend\Controllers;

class ControllerBase extends \Phalcon\Mvc\Controller
{
	public function initialize() {
		$this->tag->prependTitle ( 'Website' );
	}

}