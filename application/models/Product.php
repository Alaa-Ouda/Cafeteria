<?php

class Application_Model_Product extends Zend_Db_Table_Abstract {

	protected $_name = "products";

	function addProduct($data) {

		return $this->insert($data);
	}

	function deleteProduct($id) {
		return $this->update(array('is_deleted' => 1), "pro_id=".$id);
	}

	function getProductById($id) {
		$select = $this->select()->from(array('p' => 'products'), array('pro_id', 'pro_name', 'pro_price', 'pro_status', 'pro_image', 'c.cat_id', 'c.cat_name'));
		$select->join(array('c'                   => 'categories'), 'p.cat_id = c.cat_id', array());
		$select->where("p.is_deleted = '?'", 0)->where("p.pro_id = ?", $id)->setIntegrityCheck(FALSE);
		return $this->fetchAll($select)->toArray();
	}

	function editProduct($data, $id) {

		return $this->update($data, "pro_id=".$id);
	}

	function listProducts() {
		$select = $this->select()->from('products')->where("is_deleted = '?'", 0)->setIntegrityCheck(FALSE);

		$select = $this->fetchAll($select)->toArray();

		$paginator = Zend_Paginator::factory($select);
		return $paginator;
	}

	function listAvailableProducts() {
		$select    = $this->select()->from('products')->where("is_deleted = '?'", 0)->where("pro_status = '?'", 1)->setIntegrityCheck(FALSE);
		$select    = $this->fetchAll($select)->toArray();
		$paginator = Zend_Paginator::factory($select);
		return $paginator;
	}

}
