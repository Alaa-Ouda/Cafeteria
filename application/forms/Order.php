<?php

class Application_Form_Order extends Zend_Form {

	public function init() {
		/// step 1 create form

		$this->setMethod('post');
		$this->setAttrib('id', 'addorder');
		$user_id = new Zend_Form_Element_Hidden("user_id");
		$user_id->setAttrib('id', 'user_id');

		$order_notes = new Zend_Form_Element_Textarea("order_notes");
		$order_notes->setAttrib('rows', '4');
		$order_notes->setAttrib('cols', '30');
		$order_notes->setLabel("Notes");
		$add = new Zend_Form_Element_Submit("Confirm");
		$add->setAttrib('id', 'confirm');

		$rooms = new Zend_Form_Element_Select("room_no");
		$rooms->setLabel("Room");

		$this->addElements(array($order_notes, $rooms, $user_id, $add));
	}

}
