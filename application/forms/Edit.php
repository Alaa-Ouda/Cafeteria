<?php

class Application_Form_Edit extends Zend_Form {

	public function init() {
		/* Form Elements & Other Definitions Here ... */
		$this->setMethod("post");
		$this->setAttrib("class", "form");
		$this->setAttrib('id', 'signup');
		$this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);
		$pro_name = new Zend_Form_Element("pro_name");
		$pro_name->setLabel("Product name");
		$pro_name->setAttrib("id", "pro_name");
		$pro_name->setRequired();
		$pro_name->addFilter(new Zend_Filter_StringTrim());

		$pro_price = new Zend_Form_Element("pro_price");
		$pro_price->setLabel("Product price");
		$pro_price->setAttrib("id", "pro_price");
		$pro_price->setRequired();
		$pro_price->addFilter(new Zend_Filter_StringTrim());
		$pro_price->addFilter(new Zend_Filter_Digits());

		$pro_image = new Zend_Form_Element_File("pro_image");
		$pro_image->setLabel("Product image");
		$pro_image->setRequired();

		$pro_image->setDestination('imgs/products/');
		$pro_image->addValidator(new Zend_Validate_File_IsImage());

		$cat = new Zend_Form_Element_Select("cat_id");
		$cat->setLabel("Product Category");
		$cat->setRegisterInArrayValidator(FALSE);

		$submit = new Zend_Form_Element_Submit("Edit");
		$submit->setAttrib('class', 'red-btn');

		$reset = new Zend_Form_Element_Reset("Reset");
		$reset->setAttrib('class', 'red-btn');
		$this->addElements(array($pro_name, $pro_price, $cat, $pro_image, $submit, $reset));
	}

}
