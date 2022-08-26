<?php
require_once('../inc/autoload.php');

if (isset($_POST['id']) && isset($_POST['quantity'])){

    $out = array();
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    $catalogObj = new Catalog();
    $product = $catalogObj->getProduct($id);

    if (!empty($product)){

        switch ($quantity){
            case 0:
                Session::removeProduct($id);
                break;
            default:
                Session::addProduct($id, $quantity);
        }
    }
}