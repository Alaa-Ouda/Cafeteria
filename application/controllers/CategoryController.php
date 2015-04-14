<?php

class CategoryController extends Zend_Controller_Action {

	public function init() {
		$authorization = Zend_Auth::getInstance();
		if (!$authorization->hasIdentity()) {
			$this->redirect('index');
		}
	}

	public function indexAction() {
		// action body
	}

	public function addAction() {
		$form             = new Application_Form_Category();
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getParams())) {

				$cat_model = new Application_Model_Category();
				$cat_info  = $form->getValues();

				if ($cat_model->addCategory($cat_info)) {
					$this->redirect("product/add");
				} else {
					echo "can`t add cat";
				}
			}
		}
	}

	public function listAction() {
		// action body
		$user_model        = new Application_Model_Category();
		$this->view->users = $user_model->listCategories();
	}

}
