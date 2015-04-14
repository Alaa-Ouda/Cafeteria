<?php

class Application_Form_login extends Zend_Form {

	public function init() {
		/* Form Elements & Other Definitions Here ... */
		$this->setMethod('post');
		$this->setAttrib('id', 'login');

		$user_mail = new Zend_Form_Element_Text("user_mail");
		$user_mail->setAttrib('placeholder', 'Enter Your Email');
		$user_mail->setRequired();
		$user_mail->addValidator(new Zend_Validate_EmailAddress);

		$user_pass = new Zend_Form_Element_Password("user_pass");
		$user_pass->setAttrib('placeholder', 'Enter Your Password');
		$user_pass->setRequired();
		$user_pass->addValidator(new Zend_Validate_StringLength(array('min' => 3, 'max' => 15)));

		$submit = new Zend_Form_Element_Submit("Login");
		$submit->setAttrib('class', 'red-btn');

		$this->addElements(array($user_mail, $user_pass, $submit));
	}

}
