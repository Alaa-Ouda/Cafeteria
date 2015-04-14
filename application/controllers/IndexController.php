<?php

class IndexController extends Zend_Controller_Action {

	public function init() {
	}

	public function indexAction() {
		$authorization = Zend_Auth::getInstance();
		if ($authorization->hasIdentity()) {
			$this->redirect('user/list');
		}

		$login            = new Application_Form_login();
		$this->view->form = $login;
		if ($this->getRequest()->isPost()) {
			if ($login->isValid($this->getRequest()->getParams())) {
				$user_mail    = $this->_request->getParam('user_mail');
				$user_pass    = $this->_request->getParam('user_pass');
				$db           = Zend_Db_Table::getDefaultAdapter();
				$auth_adapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'user_mail', 'user_pass');
				$auth_adapter->setIdentity($user_mail);
				$auth_adapter->setCredential(md5($user_pass));
				$result = $auth_adapter->authenticate();
				if ($result->isValid()) {
					$auth    = Zend_Auth::getInstance();
					$storage = $auth->getStorage();
					$storage->write($auth_adapter->getResultRowObject(array('user_name', 'user_id', 'user_mail', 'user_type')));
					$this->redirect('order');
					echo "logged in";
				} else {
					echo "error login";
				}
			}
		}
	}

	public function logoutAction() {
		$authorization = Zend_Auth::getInstance();
		$authorization->clearIdentity();

		$products = new Zend_Session_Namespace('products');
		unset($products->items);

		$user = new Zend_Session_Namespace('user');
		unset($user->data);

		$this->redirect('index');
	}

}
