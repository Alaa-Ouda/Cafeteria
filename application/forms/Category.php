<?php

class Application_Form_Category extends Zend_Form {

	public function init() {
		/* Form Elements & Other Definitions Here ... */
		$this->setMethod('post');
		$this->setAttrib('id', 'login');

		$cat_name = new Zend_Form_Element_Text("cat_name");
		$cat_name->setAttrib('placeholder', 'Category Name');
		$cat_name->setRequired();

		$save = new Zend_Form_Element_Submit("Add");
		$save->setAttrib('class', 'red-btn');

		$this->addElements(array($cat_name, $save));
	}

}
