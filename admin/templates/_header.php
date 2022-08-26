<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Control Panel</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/admin-custom.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <!--[endif]-->
</head>
<body>

<!-- top navigation bar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <i style="color: #8c8c8c;" class="fa fa-bars fa-fw fa-lg"></i>
            </button>
            <a href="/admin" class="navbar-brand">Control Panel</a>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="/" target="_blank">View Site</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="/admin/?page=logout"><i class="fa fa-sign-out fa-fw fa-lg"></i>Sign Out</a></li>
            </ul>
        </div>

    </div>
</nav>
<!-- /top navigation bar -->

<!-- main container -->
<div class="container">
    <div class="row">

        <!-- sidebar navigation -->
        <div class="col-md-3 col-sm-4 col-xs-12">
            <div class="list-group">
                <a href="/admin/?page=products" class="list-group-item <?=Helper::getActive(array('page' => 'products'));?>">Products</a>
                <a href="/admin/?page=categories" class="list-group-item <?=Helper::getActive(array('page' => 'categories'));?>">Categories</a>
                <a href="/admin/?page=orders" class="list-group-item <?=Helper::getActive(array('page' => 'orders'));?>">Orders</a>
                <a href="/admin/?page=clients" class="list-group-item <?=Helper::getActive(array('page' => 'clients'));?>">Clients</a>
                <a href="/admin/?page=business" class="list-group-item <?=Helper::getActive(array('page' => 'business'));?>">Business</a>
            </div>
        </div>
        <!-- /sidebar navigation -->
