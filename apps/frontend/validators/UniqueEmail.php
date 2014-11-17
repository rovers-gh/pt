<?php

namespace Modules\Frontend\Validators;

use Phalcon\Validation\Validator;
use Phalcon\Validation\ValidatorInterface;
use Phalcon\Validation\Message;
use Modules\Frontend\Models\Entities\Users;

class UniqueEmail extends Validator implements ValidatorInterface {
	
	/**
	 * Executes the validation
	 *
	 * @param Phalcon\Validation $validator
	 * @param string $attribute
	 * @return boolean
	 */
	public function validate($validator, $attribute) {
		$value = $validator->getValue ( $attribute );
		$user = Users::findFirstByEmail($value);
		if ($user) {
			$message = $this->getOption('message');
			if (!$message){
				$message = 'The email has been registed';
			}
				
			$validator->appendMessage ( new Message ( $message, $attribute, 'email' ) );
				
			return false;
		}
		
		return true;
	}
}