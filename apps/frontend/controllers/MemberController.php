<?php

namespace Modules\Frontend\Controllers;

use Phalcon\Validation\Message;
use Modules\Frontend\Models\Entities\Users;
use Modules\Frontend\Forms\Auth\SigninForm;
use Modules\Frontend\Forms\Auth\SignupForm;

class MemberController extends ControllerBase {
	public function initialize() {
		if(!$this->session->auth) {
			return $this->response->redirect("/");
		}
	}
	public function indexAction() {
		echo $this->router->getModuleName();
		echo $this->router->getControllerName();
		echo "<br>action:",$this->router->getActionName();
	}
}

