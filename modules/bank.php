<?php
require_once('../inc/autoload.php');

$token_hash = Session::getSession('token');

$formObj = new Form();
$token = $formObj->getPost('token');

if (Login::verifyHash($token, $token_hash)) {
    
    $orderObj = new Order();
    Session::setSession('trans_type', 1);
    
    if ($orderObj->createOrder()){
        echo 1;
    } else {
        echo 0;
    }
}