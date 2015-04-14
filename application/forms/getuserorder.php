<?php

class Application_Form_getuserorder extends Zend_Form {

	public function init() {
		$user_id = new Zend_Form_Element_Hidden("user_id");
		$user_id->setAttrib("id", "userid");

		$from = new Zend_Form_Element_Text("from");
		$from->setAttrib("id", "from");
		$from->setRequired();

		$to = new Zend_Form_Element_Text("to");
		$to->setAttrib("id", "to");
		$to->setRequired();

		$this->addElements(array($user_id, $from, $to));

	}

}
