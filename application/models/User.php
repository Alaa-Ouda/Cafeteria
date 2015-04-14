<?php
class Application_Model_User extends Zend_Db_Table_Abstract {
	protected $_name = "users";

	public function addUser($data) {
		if (isset($data['user_pass'])) {
			$data['user_pass'] = md5($data['user_pass']);
		}
		$validator = new Zend_Validate_Db_RecordExists(array('table' => $this->_name, 'field' => 'user_mail',
				'exclude'                                                  => "is_deleted = 1"));
		if ($validator->isValid($data['user_mail'])) {
			echo 'this email already exist choose another email';
		} else {
			return $this->insert($data);
		}
	}

	public function listUsers() {
		$select = $this->fetchAll($this->select()->where('user_type=?', '0')->where('is_deleted=?', '0'))->toArray();

		$paginator = Zend_Paginator::factory($select);
		return $paginator;
	}

	public function listUsersWithoutPaginator() {
		$select = $this->fetchAll($this->select()->where('user_type=?', '0')->where('is_deleted=?', '0'))->toArray();
		return $select;
	}

	public function getUserById($id) {
		return $this->find($id)->toArray();
	}

	function editUser($data) {
		if (!empty($data['user_pass'])) {
			$data['user_pass'] = md5($data['user_pass']);
		} else {

			unset($data['user_pass']);
		}
		if (empty($data['user_image'])) {
			unset($data['user_image']);
		}
		return $this->update($data, "user_id = ".$data['user_id']);
	}

	public function deleteUser($id) {

		return $this->update(array('is_deleted' => 1), " user_id=".$id);
	}

	public function getRooms() {
		return $this->fetchAll($this->select()->distinct()->from($this,
				array('room_no')))->toArray();
	}

	public function getRoomExt() {
		return $this->fetchAll($this->select()->from(array($this->_name), array('room_no', 'room_ext'))
				->distinct())	->toArray();
	}

	public function checkuserEmail($email) {
		return $this->fetchAll($this->select()->from('users', array('user_id'))->where('user_mail=?', $email))->toArray();
	}

	public function updateuseremail($newpassword, $id) {
		return $this->update(array('user_pass' => $newpassword), "user_id=".$id);
	}
}
?>