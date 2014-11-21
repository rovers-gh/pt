<?php

use Phalcon\Forms\Form;

class XForm extends Form {
	public function renderDecorated($name)
	{
		$element = $this->get($name);
	
		//Get any generated messages for the current element
		$messages = $this->getMessagesFor($element->getName());
		$hasError = false;
		if (count($messages)) {
			$hasError = true;
			//Print each element
			echo '<div class="col-lg-offset-4 col-lg-8 text-danger">';
			foreach ($messages as $message) {
				echo '<div>'.$message.'</div>';
			}
			echo '</div>';
		}
		$html = '';
		switch (get_class($element)) {
			case 'Phalcon\Forms\Element\Hidden':
				$html = $this->render('csrf',array('value'=>$this->security->getToken()));
				break;
			case 'Phalcon\Forms\Element\Text':
			case 'Phalcon\Forms\Element\Email':
			case 'Phalcon\Forms\Element\File':
			case 'Phalcon\Forms\Element\Hidden':
			case 'Phalcon\Forms\Element\Numeric':
			case 'Phalcon\Forms\Element\Password':
			case 'Phalcon\Forms\Element\Radio':
			case 'Phalcon\Forms\Element\Select':
			case 'Phalcon\Forms\Element\Text':
			case 'Phalcon\Forms\Element\TextArea':
				$html = '<div class="form-group'.($hasError?' has-error':'').'">';
				$html .= '<label for="'.$element->getName().'" class="col-lg-4 control-label">'.$element->getLabel().'</label>';
				$html .= '<div class="col-lg-8">'.$element.'</div>';
				$html .= '</div>';
				break;
			case 'Phalcon\Forms\Element\Check':
				$html = '<div class="checkbox"><label>'.$element.$element->getLabel().'</label></div>';
				break;
			case 'Phalcon\Forms\Element\Submit':
				$html = '<div class="form-group">';
				$html .= '<div class="col-lg-offset-4 col-lg-8">'.$element.'</div>';
				$html .= '</div>';
				break;
		}
		echo $html;
	}
}