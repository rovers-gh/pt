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
				$email = $request->getPost('email');
				$password = $request->getPost('password');

				$user = Users::findFirstByEmail($email);
				if($user) {
					$this->flashSession->error('email was registered !');
				} else {
					$user = new Users();
					$user->setEmail($email);
					$user->setPassword($this->security->hash($password));
					$user->setRole('member');
					$user->setActive('1');
					$user->setDel_flg('0');
					$user->setRegist_url($this->getCurrentUrl());
					$success = $user->save();
					if ($success) {
						$form = new SignupForm();
						$this->flashSession->success('Thanks for registering!');
						return $this->response->redirect("auth/signin");
					} else {
						$this->flashSession->error('Sorry, the following problems were generated:');
						echo "Sorry, the following problems were generated: ";
						foreach ( $user->getMessages() as $message ) {
							echo $message->getMessage(), "<br/>";
							$this->flashSession->error($message->getMessage());
						}
					}
				}
			}
		}
		$this->view->setVar('form', $form);
	}
	public function signinAction() {
// 		$this->checkCookie();
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
				
// 				$user = Users::findFirstByEmail($email);
				$user = Users::findFirst(array(
				"email = :email: AND active = '1' AND del_flg = '0'",
				'bind' => array('email' => $email)
				));
				if ($user) {
					if ($this->security->checkHash($password, $user->getPassword())) {
						$user->setLast_login(new \Phalcon\Db\RawValue('now()'));
						$success = $user->save(null,array('last_login'));
						if ($success) {
// 							$user = Users::findFirstByEmail($email);
							$remember = $request->getPost('remember');
							$this->auth->register($user, $remember);
							$this->flashSession->success('thanks');
							$this->flashSession->success($remember);
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
		$this->auth->destory();
		return $this->response->redirect("");
	}
}

