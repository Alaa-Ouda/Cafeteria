<?php

class OrderController extends Zend_Controller_Action {

	public function init() {
		$authorization = Zend_Auth::getInstance();
		if (!$authorization->hasIdentity()) {
			$this->redirect('index');
		}
	}

	public function indexAction() {
		// create add order form
		$form           = new Application_Form_Order();
		$order_model    = new Application_Model_Orders();
		$user_model     = new Application_Model_User();
		$order_products = new Application_Model_OrderProducts();
		$products       = new Zend_Session_Namespace('products');
		$user_data      = new Zend_Session_Namespace('user');

		$authorization = Zend_Auth::getInstance();
		$authStorage   = $authorization->getStorage();
		$user_type     = $authStorage->read()->user_type;
		if ($user_type == 0) {
			$id      = $authStorage->read()->user_id;
			$user_id = $form->getElement("user_id");
			$user_id->setValue($id);
			$user_data->data        = $id;
			$order_data             = $order_model->getLatestOrder($id);
			$this->view->order_data = $order_data;
		} else {
			if (isset($user_data)) {
				$user_id = $form->getElement("user_id");
				$user_id->setValue($user_data->data);
			}
			$allusers             = $user_model->listUsersWithoutPaginator();
			$this->view->allusers = $allusers;
		}
		$allRooms = $user_model->getRooms();

		// get element from form
		$selectroom = $form->getElement("room_no");

		foreach ($allRooms as $rom) {
			$selectroom->addMultiOption($rom['room_no'], $rom['room_no']);

		}

		$this->view->addform = $form;

		$product_model = new Application_Model_Product();
		$paginator     = $product_model->listAvailableProducts();

		$page = $this->_getParam('page', 1);
		$paginator->setItemCountPerPage(3);
		$paginator->setCurrentPageNumber($page);

		$this->view->paginator = $paginator;

		if ($this->getRequest()->ispost()) {

			if ($form->isValid($this->getRequest()->getParams())) {
				$data               = $form->getValues();
				$order_date         = date('Y-m-d H:i:s');
				$data['order_date'] = $order_date;

				$order_prods   = array();
				$inserted_data = $order_model->addOrder($data);

				$order_prods['order_id'] = $inserted_data;
				foreach ($products->items as $item) {
					$order_prods['pro_id']     = $item['prod_id'];
					$order_prods['pro_amount'] = $item['prod_quantity'];
					$order_products->addOrderProduct($order_prods);
				}
				unset($products->items);
				unset($user_data->data);
				$order_notes = $form->getElement("order_notes");
				$order_notes->setValue('');

				$order_data             = $order_model->getLatestOrder(1);
				$this->view->order_data = $order_data;
			}
		}
	}
	public function chooseproductAction() {
		$product  = array();
		$flag     = false;
		$products = new Zend_Session_Namespace('products');
		if ($this->getRequest()->isPost()) {
			$status  = $this->_getParam('status');
			$prod_id = $this->_getParam('prod_id');
			if (isset($status) && $status == 'close') {
				if (isset($products->items) && count($products->items) != 0) {
					foreach ($products->items as $key => $value) {

						if (in_array($prod_id, $value)) {

							unset($products->items[$key]);
							break;
						}
					}
				}
			} else {
				$prod_name     = $this->_getParam('prod_name');
				$prod_price    = $this->_getParam('prod_price');
				$prod_quantity = $this->_getParam('prod_quantity');
				$product       = array('prod_id' => $prod_id, 'prod_name' => $prod_name, 'prod_price' => $prod_price, 'prod_quantity' => $prod_quantity);

				if (isset($products->items) && count($products->items) != 0) {
					foreach ($products->items as $key => $value) {

						if (in_array($prod_id, $value)) {

							$products->items[$key]['prod_price']    = $prod_price;
							$products->items[$key]['prod_quantity'] = $prod_quantity;
							$flag                                   = true;
							break;
						}
					}
				}

				if ($flag == false) {var_dump(true);
					if (!isset($products->items)) {
						$products->items = array();
					}

					array_push($products->items, $product);
				}
			}
		}
	}
	public function chooseuserAction() {
		$user = new Zend_Session_Namespace('user');
		if ($this->getRequest()->isPost()) {
			$user_id    = $this->_getParam('user_id');
			$user->data = $user_id;
		}
	}

	public function addAction() {
		$form = new Application_Form_Order();
		if ($this->getRequest()->ispost()) {
			$formData = $this->getRequest()->getPost();
			$form->setDefaults($formData);

			if ($form->isValid($formData)) {
				$data = $form->getValues();

				$inserted_data = $ordermodule->addOrder($data);

				$order_id               = (int) $inserted_data;
				$order_prod['order_id'] = $order_id;
			}
		}
	}

	public function editAction() {
		// action body
	}

	public function deleteAction() {
		$id = $this->getRequest()->getParam("id");
		if (isset($id)) {
			$user_model = new Application_Model_Orders();

			if ($user_model->cancelOrder($id)) {
				$this->redirect("order/getorder");
			} else {
				echo "can`t cancel order";
			}
		}
		$this->redirect("order/getorder");
	}

	public function viewAction() {
		// action body
	}

	public function listAction() {
		// action body
	}

	public function userdatechecksAction() {
		$order_model = new Application_Model_Orders();
		if ($this->getRequest()->isPost()) {
			$user_id            = $this->_getParam('user_id');
			$fromDate           = $this->_getParam('fromDate');
			$toDate             = $this->_getParam('toDate');
			$orders             = $order_model->getSpecificUserDateOrders($user_id, $fromDate, $toDate);
			$this->view->orders = $orders;
		}
	}

	public function datechecksAction() {
		$order_model = new Application_Model_Orders();
		if ($this->getRequest()->isPost()) {
			$fromDate           = $this->_getParam('fromDate');
			$toDate             = $this->_getParam('toDate');
			$orders             = $order_model->getSpecificDateOrders($fromDate, $toDate);
			$this->view->orders = $orders;
		}
	}

	public function userschecksAction() {
		$user_model  = new Application_Model_User();
		$order_model = new Application_Model_Orders();

		$allusers             = $user_model->listUsersWithoutPaginator();
		$this->view->allusers = $allusers;

		$orders             = $order_model->getAllUsersOrders();
		$this->view->orders = $orders;
	}

	public function userchecksAction() {
		$order_model = new Application_Model_Orders();
		if ($this->getRequest()->isPost()) {
			$user_id            = $this->_getParam('user_id');
			$orders             = $order_model->getSpecificUserOrders($user_id);
			$this->view->orders = $orders;
		}
	}

	public function checksAction() {

		$form = new Application_Form_checks();

		$user_model = new Application_Model_User();
		$allusers   = $user_model->listUsersWithoutPaginator();

		$user = $form->getElement('user_id');
		$user->addMultiOption('0', '-- Select User --');
		foreach ($allusers as $user_data) {
			$user->addMultiOption($user_data['user_id'], $user_data['user_name']);
		}

		$this->view->form = $form;

		$order_model = new Application_Model_Orders();

		$this->view->allusers = $allusers;

		$orders             = $order_model->getAllUsersOrders();
		$this->view->orders = $orders;
	}

	public function listorderAction() {
		$roomext    = array();
		$order      = new Application_Model_Orders();
		$user_model = new Application_Model_User();

		$this->view->orders = $order->LatestOrder();

		$roomexts = $user_model->getRoomExt();
		foreach ($roomexts as $value) {
			$roomext[$value['room_ext']] = $value['room_no'];
		}
		$this->view->roomexts = $roomext;
	}

	public function deliverorderAction() {
		$order_model = new Application_Model_Orders();
		$order_id    = $this->getRequest()->getParam("id");
		if (isset($order_id)) {
			if ($order_model->updateOrderStatus($order_id)) {
				$this->redirect("order/listorder");
			} else {
				echo "can`t update order";
			}
		}
		$this->redirect("order/listorder");
	}

	public function getorderAction() {
		$order_model = new Application_Model_Orders();
		$form        = new Application_Form_getuserorder();

		$user_data = new Zend_Session_Namespace('user');
		if (isset($user_data)) {
			$orders  = $order_model->getUserOrders($user_data->data);
			$user_id = $form->getElement("user_id");
			$user_id->setValue($user_data->data);
			$this->view->orders = $orders;
		}
		$this->view->addformm = $form;
	}

	public function userdateordersAction() {
		$order_model = new Application_Model_Orders();
		if ($this->getRequest()->isPost()) {
			$user_id            = $this->_getParam('user_id');
			$fromDate           = $this->_getParam('fromDate');
			$toDate             = $this->_getParam('toDate');
			$orders             = $order_model->getOrdersFromTo($user_id, $fromDate, $toDate);
			$this->view->orders = $orders;
		}
	}

}
