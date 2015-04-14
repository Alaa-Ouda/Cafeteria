<?php

class Application_Model_Orders extends Zend_Db_Table_Abstract {
	
	protected $_name              = "orders";
	static private $processing    = '0';
	static private $outfordeliver = '1';

	static private $deleted    = '1';
	static private $notdeleted = '0';

	function addOrder($data) {
		$this->insert($data);
		return $this->getAdapter()->lastInsertId();
	}

	function getOrders() {

		return $this->fetchAll()->toArray();
	}

	function getLatestOrder($id) {
		$select = $this->select();
		$select->setIntegrityCheck(false);
		$select->from(array('o' => $this->_name),
			array('o.order_id'))
		->join(array('op' => 'order_products'),
			'o.order_id = op.order_id',
			array('op.pro_amount'))
			->join(array('p' => 'products'),
			'op.pro_id = p.pro_id',
			array('p.pro_name', 'p.pro_image'))->where('o.user_id = ?', $id)
		                                    ->order('o.order_date DESC');
		return $this->fetchAll($select)->toArray();
	}

	function getSpecificUserDateOrders($user_id, $from_date, $to_date) {
		$select = $this->select();
		$select->setIntegrityCheck(false);
		$select->from(array('u' => 'users'),
			array('u.user_name'))
			->join(array('o' => $this->_name),
			'u.user_id = o.user_id',
			array('o.order_id', 'o.order_date'))
		->join(array('op' => 'order_products'),
			'o.order_id = op.order_id',
			array('op.pro_amount'))
			->join(array('p' => 'products'),
			'op.pro_id = p.pro_id',
			array('p.pro_name', 'p.pro_image', 'p.pro_price', '(p.pro_price*op.pro_amount) AS prod_order_price'))
			->where('o.order_date >= ?', $from_date)
			->where('o.order_date <= ?', $to_date)
			->where('o.user_id = ?', $user_id)
			->order('o.order_date DESC');
		return $this->fetchAll($select)->toArray();
	}

	function getSpecificDateOrders($from_date, $to_date) {
		$select = $this->select();
		$select->setIntegrityCheck(false);
		$select->from(array('u' => 'users'),
			array('u.user_name'))
			->join(array('o' => $this->_name),
			'u.user_id = o.user_id',
			array('o.order_id', 'o.order_date'))
		->join(array('op' => 'order_products'),
			'o.order_id = op.order_id',
			array('op.pro_amount'))
			->join(array('p' => 'products'),
			'op.pro_id = p.pro_id',
			array('p.pro_name', 'p.pro_image', 'p.pro_price', '(p.pro_price*op.pro_amount) AS prod_order_price'))
			->where('o.order_date >= ?', $from_date)
			->where('o.order_date <= ?', $to_date)
			->order('o.order_date DESC');
		return $this->fetchAll($select)->toArray();
	}

	function getSpecificUserOrders($user_id) {
		$select = $this->select();
		$select->setIntegrityCheck(false);
		$select->from(array('u' => 'users'),
			array('u.user_name'))
			->join(array('o' => $this->_name),
			'u.user_id = o.user_id',
			array('o.order_id', 'o.order_date'))
		->join(array('op' => 'order_products'),
			'o.order_id = op.order_id',
			array('op.pro_amount'))
			->join(array('p' => 'products'),
			'op.pro_id = p.pro_id',
			array('p.pro_name', 'p.pro_image', 'p.pro_price', '(p.pro_price*op.pro_amount) AS prod_order_price'))
			->where('o.user_id = ?', $user_id)
			->order('o.order_date DESC');
		return $this->fetchAll($select)->toArray();
	}

	function getAllUsersOrders() {
		$select = $this->select();
		$select->setIntegrityCheck(false);
		$select->from(array('u' => 'users'),
			array('u.user_name'))
			->join(array('o' => $this->_name),
			'u.user_id = o.user_id',
			array('o.order_id', 'o.order_date'))
		->join(array('op' => 'order_products'),
			'o.order_id = op.order_id',
			array('op.pro_amount'))
			->join(array('p' => 'products'),
			'op.pro_id = p.pro_id',
			array('p.pro_name', 'p.pro_image', 'p.pro_price', '(p.pro_price*op.pro_amount) AS prod_order_price'))
			->order('o.order_date DESC');
		return $this->fetchAll($select)->toArray();
	}

	public function LatestOrder() {
		$result = $this->select()->from(array('o' => $this->_name), array('o.order_id', 'o.order_date', 'o.order_status', 'o.user_id', 'o.order_notes', 'o.room_no'))
		->join(array('u'                          => 'users'), 'o.user_id=u.user_id', array('u.user_name'))
			->join(array('op'                        => 'order_products'), 'o.order_id=op.order_id', array('op.pro_id', 'op.pro_amount'))
			->join(array('p'                         => 'products'), 'op.pro_id=p.pro_id', array('p.pro_name', 'p.pro_price', 'p.pro_image', '(p.pro_price*op.pro_amount) AS prod_order_price'))
			->where('o.order_status = ?', self::$processing)
			->where('o.is_deleted = ?', self::$notdeleted)
			->order('o.order_date DESC');
		return $this->fetchAll($result->setIntegrityCheck(false))->toArray();
	}

	public function updateOrderStatus($id) {
		return $this->update(array('order_status' => self::$outfordeliver), "order_id=".$id);
	}

	function getUserOrders($user_id) {
		$select = $this->select();
		$select->from(array('o' => $this->_name),
			array('o.order_id', 'o.order_date', 'o.order_status'))
		->join(array('op' => 'order_products'),
			'o.order_id = op.order_id',
			array('op.pro_amount'))
			->join(array('p' => 'products'),
			'op.pro_id = p.pro_id',
			array('p.pro_name', 'p.pro_image', 'p.pro_price', '(p.pro_price*op.pro_amount) AS prod_order_price'))
			->where('o.user_id = ?', $user_id)
			->where('o.is_deleted = ?', self::$notdeleted)
			->order('o.order_date DESC');
		return $this->fetchAll($select->setIntegrityCheck(false))->toArray();
	}

	function getOrdersFromTo($user_id, $from, $to) {
		$select = $this->select();
		$select->from(array('o' => $this->_name),
			array('o.order_id', 'o.order_date', 'o.order_status'))
		->join(array('op' => 'order_products'),
			'o.order_id = op.order_id',
			array('op.pro_amount'))
			->join(array('p' => 'products'),
			'op.pro_id = p.pro_id',
			array('p.pro_name', 'p.pro_image', 'p.pro_price', '(p.pro_price*op.pro_amount) AS prod_order_price'))
			->where('o.user_id = ?', $user_id)
			->where('o.order_date >= ?', $from)
			->where('o.order_date <= ?', $to)
			->where('o.is_deleted = ?', self::$notdeleted)
			->order('o.order_date DESC');
		return $this->fetchAll($select->setIntegrityCheck(false))->toArray();
	}

	public function cancelOrder($id) {
		return $this->update(array('is_deleted' => self::$deleted), "order_id=".$id);
	}
}
