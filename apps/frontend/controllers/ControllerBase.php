<?php

namespace Modules\Frontend\Controllers;

use Modules\Frontend\Models\Entities\Users;

class ControllerBase extends \Phalcon\Mvc\Controller {
	public function initialize() {
		$this->tag->prependTitle('Website');
	}
	public function getCurrentUrl() {
		return $this->request->getScheme().'://'.$this->request->getHttpHost().$this->request->getURI();
	}
}