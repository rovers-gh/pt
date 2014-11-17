<?php
namespace Modules\Frontend\Forms\Auth;

use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Identical;
use Modules\Frontend\Models\Entities\Users;
use Modules\Frontend\Validators\UniqueEmail;

class SigninForm extends \XForm {
	
	public function initialize() {
// 		$user = new User();
		// Set the same form as entity
// 		$this->setEntity($user);
		
		// Add a text element to capture the 'email'
		$email = new Email("email",array('class'=>'form-control', 'placeholder' => 'Email'));
		$email->setLabel("Email");
        $email->setFilters('email');
		$email->addValidators(array(
				new PresenceOf(array(
						'message' => 'Enter your email address.',
						'cancelOnFail' => true
				)),
				new \Phalcon\Validation\Validator\Email(array(
						'message' => 'The e-mail is not valid'
				)),
		));
		$this->add($email);

		$password = new Password("password",array('class'=>'form-control', 'placeholder' => 'Password'));
		$password->setLabel("Password");
		$password->addValidators(array(
				new PresenceOf(array(
						'message' => 'Enter your password.'
				)),
		));
		$this->add($password);
		
		// Add a text element to put a hidden csrf
		$csrf = new Hidden('csrf',array());
		$csrf->addValidator(new Identical(array(
				'value' => $this->security->getSessionToken(),
				'message' => 'CSRF validation failed'
		)));
// 		$csrf = new Hidden('csrf', array(
// 				'name' => $this->security->getTokenKey(),
// 				'value' => $this->getCsrf(),
// 		));
// 		$csrf->addValidator(new Identical(array(
// 				'value' => $this->security->getToken(),
// 				'message' => 'CSRF validation failed'
// 		)));
		$this->add($csrf);
		
		$submit = new Submit('Sign in', array('class' => 'form-control btn btn-primary'));
		$submit->setLabel("Sign in");
		$this->add($submit);
	}
}