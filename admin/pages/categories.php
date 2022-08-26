<?php
Login::restrictAdmin();

$action = Url::getParam('action');
switch ($action) {
    case 'add':
        require_once('categories/add.php');
        break;
    case 'edit':
        require_once('categories/edit.php');
        break;
    case 'remove':
        require_once('categories/remove.php');
        break;
    case 'report':
        require_once('categories/report.php');
        break;
    default:
        require_once('categories/list.php');
}
