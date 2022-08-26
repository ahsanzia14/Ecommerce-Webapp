<?php
Login::restrictAdmin();

$action = Url::getParam('action');
switch ($action) {
    case 'edit':
        require_once('clients/edit.php');
        break;
    case 'remove':
        require_once('clients/remove.php');
        break;
    case 'report':
        require_once('clients/report.php');
        break;
    default:
        require_once('clients/list.php');
    }
