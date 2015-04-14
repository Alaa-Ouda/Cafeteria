<?php

class ProductController extends Zend_Controller_Action {

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
		// action body
		$form = new Application_Form_Product();

		$model   = new Application_Model_Category();
		$cat_arr = $model->listCategories();

		$catName = $form->getElement('cat_id');
		$catName->addMultiOption('0', '-- Select Category --');
		foreach ($cat_arr as $cats) {
			$catName->addMultiOption($cats['cat_id'], $cats['cat_name']);
		}
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getParams())) {
				$data              = $form->getValues();
				$data['pro_image'] = 'imgs/products/'.$data['pro_image'];
				$model             = new Application_Model_Product();
				if ($model->addProduct($data)) {
					$this->redirect("product/list");
				}
			}
		}
	}

	public function editAction() {
		$form = new Application_Form_Edit();
		$pid  = $this->getRequest()->getParam("id");
		if ($this->getRequest()->isGet()) {
			$model   = new Application_Model_Product();
			$info    = $model->getProductById($pid);
			$model   = new Application_Model_Category();
			$cat_arr = $model->listCategories();

			$catName = $form->getElement('cat_id');
			foreach ($cat_arr as $cats) {
				$catName->addMultiOption($cats['cat_id'], $cats['cat_name']);
			}

			$this->view->form = $form;
			unset($info[0]['pro_image']);
			$form->populate($info[0]);
			$this->view->form = $form;

		}
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getParams())) {
				$data              = $form->getValues();
				$data['pro_image'] = 'imgs/products/'.$data['pro_image'];
				$upload            = new Zend_File_Transfer();
				$upload->receive();
				$model = new Application_Model_Product();
				if ($model->editProduct($data, $pid)) {

					$this->redirect("product/list");
				}
			} else {
				echo "error in editing";
			}
		}
	}

	public function deleteAction() {
		// action body
		$id = $this->getRequest()->getParam("id");
		if (isset($id)) {
			$model = new Application_Model_Product();
			if ($model->deleteProduct($id)) {
				$this->redirect("product/list");
			}

		}
	}

	public function viewAction() {
		// action body
		$pid = $this->getRequest()->getParam("id");
		if ($this->getRequest()->isGet()) {
			$model                   = new Application_Model_Product();
			$info                    = $model->getProductById($pid);
			$this->view->productInfo = $info;
		}

	}

	public function listAction() {
		// action body
		$model     = new Application_Model_Product();
		$paginator = $model->listProducts();

		$page = $this->_getParam('page', 1);
		$paginator->setItemCountPerPage(2);
		$paginator->setCurrentPageNumber($page);

		$this->view->paginator = $paginator;
	}

	public function changeAction() {
		// action body
		$pid    = $this->getRequest()->getParam("id");
		$status = $this->getRequest()->getParam("s");
		if ($this->getRequest()->isGet()) {
			$model = new Application_Model_Product();
			$data  = array('pro_status' => $status);
			if ($model->editProduct($data, $pid)) {
				$this->redirect("product/list");

			}
		}
		$this->redirect("product/list");
	}

}
