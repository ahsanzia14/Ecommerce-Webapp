<?php
require_once('../inc/autoload.php');

if (isset($_POST['id'])){

    $product_id = $_POST['id'];
    Session::removeProduct($product_id);
}