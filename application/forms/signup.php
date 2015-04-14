<?php

class Application_Form_signup extends Zend_Form {

	public function init() {
		/* Form Elements & Other Definitions Here ... */
		$this->setMethod('post');
		$this->setAttrib('class', 'form');
		$this->setAttrib('id', 'signup');
		$user_id = new Zend_Form_Element_Hidden("user_id");

		$user_name = new Zend_Form_Element_Text("user_name");
		$user_name->setLabel("Username");
		$user_name->setRequired();

		$user_pass = new Zend_Form_Element_Password("user_pass");
		$user_pass->setLabel("User Password");
		$user_pass->setRequired();
		$user_pass->addValidator(new Zend_Validate_StringLength(array('min' => 3, 'max' => 15)));

		$confirm_password = new Zend_Form_Element_Password("confirm_password");
		$confirm_password->setLabel("Confirm Password");
		$confirm_password->setRequired();
		$confirm_password->addValidator(new Zend_Validate_StringLength(array('min' => 3, 'max' => 15)));

		$user_mail = new Zend_Form_Element_Text("user_mail");
		$user_mail->setLabel("User Email");
		$user_mail->setRequired();
		$user_mail->addValidator(new Zend_Validate_EmailAddress);

		$room_no = new Zend_Form_Element_Text("room_no");
		$room_no->setLabel("Room No.");
		$room_no->setRequired();
		$room_no->addValidator(new Zend_Validate_Int());

		$room_ext = new Zend_Form_Element_Text("room_ext");
		$room_ext->setLabel("Room Ext.");
		$room_ext->setRequired();
		$room_ext->addValidator(new Zend_Validate_StringLength(array('min' => 1, 'max' => 5)));

		$user_image = new Zend_Form_Element_File("user_image");
		//$user_image->setRequired();
		$user_image->setLabel("User Image");
		$user_image->addValidator(new Zend_Validate_File_IsImage());
		$user_image->setValueDisabled(true);

		$save = new Zend_Form_Element_Submit("Add");
		$save->setAttrib('class', 'red-btn');
		$reset = new Zend_Form_Element_Reset("Reset");
		$reset->setAttrib('class', 'red-btn');

		$this->addElements(array($user_id, $user_name, $user_mail, $user_pass, $confirm_password, $room_no, $room_ext, $user_image, $save, $reset));
	}

}
