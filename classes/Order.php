<?php

class Order extends Application {

	private $_table_orders = 'orders';
	private $_table_orders_items = 'orders_items';
	private $_table_statuses = 'statuses';

	private $_basket = array();
	private $_items = array();

	// $_fields = array();
	// $_values = array();

	private $_id = null;


	public function getItems()
	{
		$this->_basket = Session::getSession('basket');

		if (!empty($this->_basket)) {
			$catalogObj = new Catalog();

			foreach ($this->_basket as $key => $value) {
				$this->_items[$key]	= $catalogObj->getProduct($key);
			}
		}
	}

	public function createOrder()
	{
		$this->getItems();

		if (!empty($this->_items)) {

			$userObj = new User();
			$user = $userObj->getUserById(Session::getSession(Login::$_login_client));

			if (!empty($user)) {

				$basketObj = new Basket();

				$values = array(
					$user['id'],
					$basketObj->_vat_rate,
					$basketObj->_vat,
					$basketObj->_sub_total,
					$basketObj->_total,
					!empty(Session::getSession('trans_type'))? Session::getSession('trans_type'): 0,
					Helper::setDate()
				);

				$sql = "INSERT INTO $this->_table_orders 
						(client, vat_rate, vat, subtotal, total, `type`, `date`)
						VALUES (?, ?, ?, ?, ?, ?, ?);";

				$this->db->prepare($sql);
				$this->db->bind('issssis', $values);
				if ($this->db->execute()) {

					$this->_id = $this->db->_id;
					return $this->addOrderItems();
				}
			}
		}
	}

	public function addOrderItems()
	{
		$placeHolders = $types = $values = array();

		foreach ($this->_items as $key => $item){
			$placeHolders[] = '(?, ?, ?, ?)';
			$types[] = 'iidi';
			$values[] = $this->_id;
			$values[] = $item['id'];
			$values[] = $item['price'];
			$values[] = $this->_basket[$item['id']]['quantity'];
		}

		$placeHolders = implode(', ', $placeHolders);
		$types = implode('', $types);

		$sql = "INSERT INTO $this->_table_orders_items (`order`, product, price, qty) VALUES $placeHolders;";
		$this->db->prepare($sql);
		$this->db->bind($types, $values);
		return $this->db->execute();
	}

	public function getOrder($id = null)
	{
		$id = (!empty($id))? $id: $this->_id;

		$sql = "SELECT * FROM $this->_table_orders WHERE id = ?";

		$this->db->prepare($sql);
		$this->db->bind('i', $id);
		return $this->db->single();
	}

	public function getOrderItems($id = null)
	{
		$id = !empty($id)? $id: $this->_id;

		$sql = "SELECT * FROM $this->_table_orders_items WHERE `order` = ?";

		$this->db->prepare($sql);
		$this->db->bind('i', array($id));
		return $this->db->resultSet();
	}

//	public function approveOrder($txn_id = null, $payment_status = null, $id = null)
//	{
//		if (!empty($id) && !empty($payment_status) && !empty($txn_id)){
//
//			$sql = "UPDATE $this->_table_orders
//					SET txn_id = ?, pp_status = ?, payment_status = ?
//					WHERE id = ?;";
//			$activeFlag = ($payment_status == 'completed')? 1: 0;
//
//			$this->db->prepare($sql);
//			$this->db->bind('sisi', array($txn_id, $activeFlag, $payment_status, $id));
//			return $this->db->execute();
//		}
//	}

	public function approveOrder($array = null, $result = null)
	{
		if (!empty($array) && !empty($result)){
			if (
				array_key_exists('txn_id', $array) &&
				array_key_exists('payment_status', $array) &&
				array_key_exists('custom', $array)){

				$out = array();
				foreach ($array as $key => $value){
					$out[] = "$key: $value";
				}
				$out = implode("\n", $out);

				$activeFlag = ($array['payment_status'] == 'Completed')? 1: 0;

				$sql = "UPDATE $this->_table_orders 
						SET txn_id = ?, pp_status = ?, payment_status = ?, ipn = ?, response = ? 
						WHERE id = ?;";

				$this->db->prepare($sql);
				$this->db->bind('sisssi',
					array(
						$array['txn_id'],
						$activeFlag,
						$array['payment_status'],
						$out,
						$result,
						$array['custom']
					)
				);

				return $this->db->execute();
			}
		}
		return false;
	}

	public function getClientOrders($id = null)
	{
		if (!empty($id)){
			$sql = "SELECT orders.*, statuses.name FROM orders 
					LEFT JOIN statuses ON orders.status = statuses.id 
					WHERE client = ? 
					ORDER BY `date` DESC;";

			$this->db->prepare($sql);
			$this->db->bind('i', array($id));
			return $this->db->resultSet();
		}
	}

	public function getOrders($search = null)
	{
		$types = null;
		$sql = "SELECT $this->_table_orders.*, $this->_table_statuses.name 
				FROM $this->_table_orders 
				JOIN $this->_table_statuses ON $this->_table_orders.status = $this->_table_statuses.id ";

		if (!empty($search)){
			$sql .= "WHERE $this->_table_orders.id = ?;";
			$types = 'i';
		} else {
			$sql .= "ORDER BY `date` DESC;";
		}

		$this->db->prepare($sql);
		$this->db->bind($types, $search);
		return $this->db->resultSet();
	}

	public function getStatuses()
	{
		$sql = "SELECT * FROM $this->_table_statuses;";
		return $this->db->fetchAll($sql);
	}

	public function updateOrder($array = array(), $id = null)
	{
		if (!empty($array) && !empty($id)){
			$types = $values = $keys = array();
			foreach ($array as $key => $value){
				$keys[] = $key.' = ?';
				$values[] = $value;
				$types[] = 's';
			}
			$types[] = 'i';
			$values[] = (int) $id;
			$keys = implode(', ', $keys);
			$types = implode('', $types);

			$sql = "UPDATE $this->_table_orders SET $keys WHERE id = ?;";
			$this->db->prepare($sql);
			$this->db->bind($types, $values);
			return $this->db->execute();
		}
	}

	public function removeOrder($id = null)
	{
		if (!empty($id)){
			$sql = "DELETE FROM $this->_table_orders WHERE id = ?;";
			$this->db->prepare($sql);
			$this->db->bind('i', $id);
			return $this->db->execute();
		}
		return false;
	}

	public function getReport()
	{
		$sql = "SELECT COUNT(status) AS total, statuses.name 
                FROM statuses 
                LEFT JOIN orders ON orders.status = statuses.id 
                GROUP BY statuses.name 
                ORDER BY statuses.name ASC;";

		$report = $this->db->fetchAll($sql);
		if (!empty($report)){
			$total = 0;
			foreach ($report as $row){
				$total += $row['total'];
			}

			$report['total'] = $total;
			return $report;
		}
		return null;
	}

//	public function getClientOrders($id = null)
//	{
//		if (!empty($id)){
//			$sql = "SELECT * FROM orders WHERE client = ? ORDER BY `date` DESC;";
//			$this->db->prepare($sql);
//			$this->db->bind('i', array($id));
//			return $this->db->resultSet();
//		}
//	}

//	public function getStatus($id = null)
//	{
//		if (!empty($id)){
//			$sql = "SELECT `name` FROM statuses WHERE id = ?";
//			$this->db->prepare($sql);
//			$this->db->bind('i', array($id));
//			return $this->db->single()['name'];
//		}
//	}

}