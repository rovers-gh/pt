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

class SignupForm extends \XForm {
	
	/**
	 * This method returns the default value for field 'csrf'
	 */
	public function getCsrf() {
		return $this->security->getToken();
	}
	public function initialize() {
// 		$user = new User();
		// Set the same form as entity
// 		$this->setEntity($user);
		
		// Add a text element to capture the 'email'
		$email = new Email("email",array('class'=>'form-control', 'placeholder' => 'Enter your email address'));
		$email->setLabel("Email");
        $email->setFilters('email');
		$email->addValidators(array(
				new PresenceOf(array(
						'message' => 'The e-mail is required',
						'cancelOnFail' => true
				)),
				new \Phalcon\Validation\Validator\Email(array(
						'message' => 'The e-mail is not valid'
				)),
				new UniqueEmail()
		));
		$this->add($email);

		$password = new Password("password",array('class'=>'form-control', 'placeholder' => '6 characters or more! Be tricky.'));
		$password->setLabel("Password");
		$password->addValidators(array(
				new PresenceOf(array(
						'message' => 'Password is required'
				)),
				new Confirmation(array(
						'message' => 'Password doesn\'t match confirmation',
						'with' => 'password2'
				))
		));
// 		$password->addValidator(new PresenceOf(array(
// 				'message' => 'The password is required'
// 		)));
// 		$password->addValidator(new Confirmation(array(
// 				'message' => 'Password doesn\'t match confirmation',
// 				'with' => 'password2'
// 		)));
		$this->add($password);
		
		$password2 = new Password("password2",array('class'=>'form-control','placeholder' => 'Enter your password again for confirm'));
		$password2->setLabel("Confirmation Password");
		$password2->addValidator(new PresenceOf(array(
				'message' => 'Confirmation password is required'
		)));
		$this->add($password2);
		
		// Add a text element to put a hidden csrf
		$csrf = new Hidden('csrf');
		
		$csrf->addValidator(new Identical(array(
				'value' => $this->security->getSessionToken(),
				'message' => 'CSRF validation failed'
		)));
		
		$this->add($csrf);
		
		$this->add(new Submit('Sign up', array(
				'class' => 'btn btn-success'
		)));
	}
}