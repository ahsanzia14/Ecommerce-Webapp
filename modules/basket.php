<?php
require_once('../inc/autoload.php');

if (isset($_POST['id']) && isset($_POST['job'])) {

	$out = array();

	$id = $_POST['id'];
	$job = $_POST['job'];

	$catalogObj = new Catalog();
	$product = $catalogObj->getProduct($id);

	if (!empty($product)) {
		
		switch ($job) {
			case 0:
				Session::removeProduct($id);
				$out['job'] = 1;
				break;
			case 1:
				Session::addProduct($id);
				$out['job'] = 0;
				break;
		}

		echo json_encode($out);
	}
}