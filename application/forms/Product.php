<?php

class Application_Form_Product extends Zend_Form {

	public function init() {
		/* Form Elements & Other Definitions Here ... */
		$this->setMethod("post");
		$this->setAttrib("class", "form");
		$this->setAttrib('id', 'signup');
		$this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);
		$pro_name = new Zend_Form_Element("pro_name");
		$pro_name->setLabel("Product Name");
		$pro_name->setAttrib("id", "pro_name");
		$pro_name->setRequired();
		$pro_name->addFilter(new Zend_Filter_StringTrim());

		$pro_price = new Zend_Form_Element("pro_price");
		$pro_price->setLabel("Product Price");
		$pro_price->setAttrib("id", "pro_price");
		$pro_price->setRequired();
		$pro_price->addFilter(new Zend_Filter_StringTrim());
		$pro_price->addFilter(new Zend_Filter_Digits());

		$pro_image = new Zend_Form_Element_File("pro_image");
		$pro_image->setLabel("Product Image");
		$pro_image->setRequired();

		$pro_image->setDestination('imgs/products/');

		$cat = new Zend_Form_Element_Select("cat_id");
		$cat->setLabel("Product Category");
		$cat->setAttrib('id', 'prod_cat');

		$submit = new Zend_Form_Element_Submit("Add");
		$submit->setAttrib('class', 'red-btn');

		$reset = new Zend_Form_Element_Reset("Reset");
		$reset->setAttrib('class', 'red-btn');

		$this->addElements(array($pro_name, $pro_price, $cat, $pro_image, $submit, $reset));

	}

}
