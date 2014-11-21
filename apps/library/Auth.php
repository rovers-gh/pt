<?php
use Phalcon\Mvc\User\Component;
use Modules\Frontend\Models\Entities\Users;

class Auth extends Component {
	public function hasRememberMe()
	{
		return $this->cookies->has('RMU');
	}
	public function registerAuth(Users $user, $remember) {
		$this->session->set('auth', array (
				'id' => $user->getId(),
				'name' => $user->getName() ? $user->getName() :$user->getEmail()
		));
		if($remember == 'yes') {
			$expire = time() + 86400;
			$this->cookies->set('RMU', $user->getId(), $expire);
		}
	}
	public function checkCookie() {
		if ($this->hasRememberMe()) {
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