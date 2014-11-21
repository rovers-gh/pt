<?php
namespace Modules\Frontend\Forms\Auth;

use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Check;
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
		// Email
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

		// Password
		$password = new Password("password",array('class'=>'form-control', 'placeholder' => 'Password'));
		$password->setLabel("Password");
		$password->addValidators(array(
				new PresenceOf(array(
						'message' => 'Enter your password.'
				)),
		));
		$this->add($password);
		
		// Remember
		$remember = new Check('remember', array('value' => 'yes'));
		$remember->setLabel('Remember me');
		$this->add($remember);
		
		// CSRF
		$csrf = new Hidden('csrf',array());
		$csrf->addValidator(new Identical(array(
				'value' => $this->security->getSessionToken(),
				'message' => 'CSRF validation failed'
		)));
		$this->add($csrf);
		
		// Submit
		$submit = new Submit('Sign in', array('class' => 'form-control btn btn-primary'));
		$submit->setLabel("Sign in");
		$this->add($submit);
	}
}