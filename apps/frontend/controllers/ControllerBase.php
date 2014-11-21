<?php

namespace Modules\Frontend\Controllers;

use Modules\Frontend\Models\Entities\Users;

class ControllerBase extends \Phalcon\Mvc\Controller {
	public function initialize() {
		$this->tag->prependTitle('Website');
// 		$this->checkCookie();
	}
	private function checkCookie() {
		if ($this->cookies->has('RMU')) {
			// Get the cookie
			$rememberMe = $this->cookies->get('RMU');
			
			// Get the cookie's value
			$userId = $rememberMe->getValue();
			$user = Users::findFirstById($userId);
			if($user && $user->getDel_flg() === '0') {
				$this->session->set('auth', array (
						'id' => $user->getId(),
						'name' => $user->getName() ? $user->getName() :$user->getEmail()
				));
			} else {
				$this->cookies->delete('RMU');
			}
		}
	}
}