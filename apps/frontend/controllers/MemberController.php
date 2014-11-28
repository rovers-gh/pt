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
		$message = \Swift_Message::newInstance('Wonderful Subject')
		->setFrom(array('test4aipo@vista-sys.com' => 'TEST'))
		->setTo(array('xiao.xuebin@vista-sys.com' => 'A name'))
		->setBody('Here is the message itself')
		;
		$result = $this->mailer->send($message);
		print_r($result);
	}
}

