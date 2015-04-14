<?php

class Application_Form_checks extends Zend_Form {

	public function init() {
		$fromdate = new Zend_Form_Element_Text("fromDate");
		$fromdate->setAttrib("id", "fromDate");

		$todate = new Zend_Form_Element_Text("toDate");
		$todate->setAttrib("id", "toDate");

		$user = new Zend_Form_Element_Select('user_id');
		$user->setAttrib("id", "users");

		$this->addElements(array($fromdate, $todate, $user));

	}

}
