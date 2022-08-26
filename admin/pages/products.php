<?php
Login::restrictAdmin();

$action = Url::getParam('action');
switch ($action) {
    case 'add':
        require_once('products/add.php');
        break;
    case 'edit':
        require_once('products/edit.php');
        break;
    case 'remove':
        require_once('products/remove.php');
        break;
    case 'report':
        require_once('products/report.php');
        break;
    default:
        require_once('products/list.php');
    }
