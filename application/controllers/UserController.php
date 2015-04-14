<?php

class UserController extends Zend_Controller_Action {

	public function init() {
		$authorization = Zend_Auth::getInstance();
		$url           = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
		$url_array     = explode('/', $url);
		if (count($url_array) == 2 && $url_array[0] == 'user' && $url_array[1] == 'forgetpassword') {
		} else {
			if (!$authorization->hasIdentity()) {
				$this->redirect('index');
			}
		}
	}

	public function indexAction() {
		// action body
	}

	public function addAction() {
		// action body
		$form             = new Application_Form_signup();
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getParams())) {
				if ($form->getElement('user_pass')->getValue() != $form->getElement('confirm_password')->getValue()) {
					echo "password notmatced";
				} else {
					$user_model = new Application_Model_User();

					$form->removeElement('confirm_password');
					$user_info               = $form->getValues();
					$imagename               = end(explode('.', $form->getElement('user_image')->getValue()));
					$img                     = time().'_'.$imagename;
					$path                    = './pic/'.$img;
					$user_info['user_image'] = $img;
					$form->getElement('user_image')->addFilter('Rename', array('target' => $path, 'overwrite' => true));
					$form->getElement('user_image')->receive();
					if ($user_model->addUser($user_info)) {$this->redirect("user/list");} else {

						echo "can`t add user";

					}
				}
			}
		}
	}

	public function listAction() {
		// action body
		$user_model = new Application_Model_User();

		$paginator = $user_model->listUsers();

		$page = $this->_getParam('page', 1);
		$paginator->setItemCountPerPage(2);
		$paginator->setCurrentPageNumber($page);

		$this->view->paginator = $paginator;
	}

	public function editAction() {
		$id         = $this->getRequest()->getParam('user_id');
		$user_model = new Application_Model_User();
		$form       = new Application_Form_signup();
		if (isset($id)) {

			$form->getElement('user_pass')->removeValidator('Zend_Validate_StringLength')->setRequired(false);
			$form->getElement('confirm_password')->removeValidator('Zend_Validate_StringLength')->setRequired(false);
			$form->getElement('user_image')->setRequired(false);

			$user_info = $user_model->getUserById($id);
			if (!empty($user_info)) {
				$form->removeElement('confirm_password');
				$form->populate($user_info[0]);
				$this->view->form = $form;
				$this->render('add');
			}
		}
		if ($this->getRequest()->isPost()) {

			if ($form->isValid($this->getRequest()->getParams())) {
				$usernewdata = $form->getValues();
				if (empty($usernewdata['user_image'])) {
					unset($usernewdata['user_image']);
					if ($user_model->editUser($usernewdata)) {$this->redirect('user/list');}
				} else {
					$imagename                 = end(explode('.', $form->getElement('user_image')->getValue()));
					$img                       = time().'_'.$imagename;
					$path                      = './pic/'.$img;
					$usernewdata['user_image'] = $img;
					$form->getElement('user_image')->addFilter('Rename', array('target' => $path, 'overwrite' => true));
					$form->getElement('user_image')->receive();
					if ($user_model->editUser($usernewdata)) {$this->redirect('user/list');}
				}
			}

		}

	}

	public function deleteAction() {

		$id = $this->getRequest()->getParam("user_id");
		if (isset($id)) {
			$user_model = new Application_Model_User();
			if ($user_model->deleteUser($id)) {
				$this->redirect("user/list");
			} else {
				echo "can`t delete user";
			}
		}

	}

	public function forgetpasswordAction() {
		$form = new Application_Form_login();
		$form->removeElement('user_pass');
		$form->getElement('Login')->setLabel('Send');
		$this->view->form = $form;
		if ($form->isValid($this->getRequest()->getParams())) {
			$email     = $this->_request->getParam('user_mail');
			$usermodel = new Application_Model_User();

			if ($userid = $usermodel->checkuserEmail($email)) {

				$newpassword = substr(hash('sha512', rand()), 0, 8);

				$smtpoptions = array(
					'auth'     => 'login',
					'username' => 'hoda.sheir@gmail.com',
					'password' => '386691',
					'ssl'      => 'tls',
					'port'     => 587,
				);
				$mailtransport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $smtpoptions);
				$mail          = new Zend_Mail();
				$mail->addTo($email, 'to You');
				$mail->setSubject('Hello  User');
				$mail->setBodyText('message from OmGamal your new password is '.$newpassword);
				$mail->setFrom('hoda.sheir@gmail.com', 'om Gamal Cafetria');

				//Send it!
				$sent = true;
				try {
					$mail->send($mailtransport);
				} catch (Exception $e) {

					$sent = false;
				}

				//Do stuff (display error message, log it, redirect user, etc)
				if ($sent) {
					if ($usermodel->updateuseremail(md5($newpassword), $userid[0]['user_id'])) {
						echo 'Successfully Sent Please Check your Email';
					} else {
						echo 'Error in Server';
					}

				} else {
					echo 'Failed Sending to your Email Please Check your Settings';
				}

			} else {

				echo 'This Email is not Existed in my Database';
			}

		}
	}

}
