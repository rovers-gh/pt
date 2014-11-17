<?php

namespace Modules\Frontend\Controllers;

use Phalcon\Validation\Message;
use Modules\Frontend\Models\Entities\Users;
use Modules\Frontend\Forms\Auth\SigninForm;
use Modules\Frontend\Forms\Auth\SignupForm;

class AuthController extends ControllerBase {
	public function signupAction() {
		$this->tag->appendTitle(" | Sign up");
		$request = $this->request;
		$form = new SignupForm();
		
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$user = new Users();
				$email = $request->getPost('email');
				$password = $request->getPost('password');
				
				$user->setEmail($email);
				$user->setPassword($this->security->hash($password));
				$user->setRole('member');
				$user->setActive('N');
				$success = $user->save();
				if ($success) {
					$form = new SignupForm();
					$this->flashSession->success('Thanks for registering!');
					return $this->response->redirect("auth/signin");
				} else {
					echo "Sorry, the following problems were generated: ";
					foreach ( $user->getMessages() as $message ) {
						echo $message->getMessage(), "<br/>";
					}
				}
			}
		}
		$this->view->setVar('form', $form);
	}
	public function signinAction() {
		if ($this->session->auth) {
			return $this->response->redirect("");
		}
		$this->tag->appendTitle(" | Sign in");
		$request = $this->request;
		$form = new SigninForm();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$email = $request->getPost('email');
				$password = $request->getPost('password');
				
				$user = Users::findFirstByEmail($email);
				// $user = Users::findFirst(array(
				// "(email = :email: OR username = :email:) AND password = :password: AND active = '1'",
				// 'bind' => array('email' => $email, 'password' => sha1($password))
				// ));
				// $this->view->disable();print_r($user);
				if ($user) {
					if ($this->security->checkHash($password, $user->getPassword())) {
						$user->setLast_login(new \Phalcon\Db\RawValue('now()'));
						$success = $user->save();
						if ($success) {
							$user = Users::findFirstByEmail($email);
							$this->session->set('auth', array (
									'id' => $user->getId(),
									'email' => $user->getEmail(),
									'role' => $user->getRole(),
									'last_login' => $user->getLast_login() 
							));
							$this->flashSession->success('thanks');
							return $this->response->redirect("");
						} else {
							$this->flashSession->error('update login time failed.');
							foreach ( $user->getMessages() as $message ) {
								$this->flashSession->error($message);
							}
						}
					} else {
						$this->flashSession->error('Wrong email/password combination');
					}
				} else {
					$this->flashSession->error('not exist');
				}
			} else {
				foreach ( $form->getMessages() as $message ) {
					$this->flashSession->error($message);
				}
			}
		}
		$this->view->setVar('form', $form);
	}
	public function signoutAction() {
		$this->view->disable();
		$this->session->remove('auth');
		return $this->response->redirect("");
	}
	private function createRememberEnviroment(Users $user) {
		$userAgent = $this->request->getUserAgent();
		$token = md5($user->email . $user->password . $userAgent);
		
		$expire = time() + 86400 * 8;
		$this->cookies->set('RMU', $user->id, $expire);
		$this->cookies->set('RMT', $token, $expire);
	}
	private function hasRememberMe() {
		return $this->cookies->has('RMU');
	}
}

