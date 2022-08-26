<?php
Login::restrictAdmin();

$action = Url::getParam('action');

switch ($action) {
    case 'account':
        require_once('business/account.php');
        break;
    default:
        require_once('business/edit.php');
}
