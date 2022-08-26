<?php
require_once('../inc/autoload.php');

$token_hash = Session::getSession('token');

$formObj = new Form();
$token = $formObj->getPost('token');

if (Login::verifyHash($token, $token_hash)) {
	$orderObj = new Order();
	if ($orderObj->createOrder()){

		$order = $orderObj->getOrder();
		$items = $orderObj->getOrderItems();

		if (!empty($order) && !empty($items)){

			$basketObj = new Basket();
			$catalogObj = new Catalog();
			$paypalObj = new PayPal();

			foreach ($items as $item){
				$product = $catalogObj->getProduct($item['product']);
				$catalogObj->updateProduct(array('qty' => $product['qty'] - $item['qty']), $item['product']);
				$paypalObj->addProduct(
							$item['product'],
							$product['name'],
							$item['price'],
							$item['qty']
				);
			}

			$paypalObj->_tax_cart = $basketObj->_vat;

			$userObj = new User();
			$user = $userObj->getUserById($order['client']);

			if (!empty($user)){
				$countryObj = new Country();
				$country = $countryObj->getCountry($user['country']);

				$paypalObj->_populate = array(
					'first_name' 	=> $user['first_name'],
					'last_name'		=> $user['last_name'],
					'email' 		=> $user['email'],
					'address1' 		=> $user['address_1'],
					'address2' 		=> $user['address_2'],
					'city' 			=> $user['town'],
					'state' 		=> $user['county'],
					'country' 		=> $country['code'],
					'zip' 			=> $user['post_code']
				);

				echo $paypalObj->run($order['id']);
			}
		}
	}
}