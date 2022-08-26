<?php
require_once('../inc/autoload.php');

$basketObj = new Basket();

$out = array();
$out['bl_ti'] = $basketObj->_num_of_items;
$out['bl_st'] = number_format($basketObj->_sub_total, 2);
$out['bl_vat'] = number_format($basketObj->_vat, 2);
$out['bl_total'] = number_format($basketObj->_total, 2);

echo json_encode($out);
