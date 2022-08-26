<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= htmlspecialchars($business['name']); ?></title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <!--[endif]-->
</head>

<body>

<!-- logo -->
<header class="page-header hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-8">
                <h1><i><?= htmlspecialchars($business['name']); ?></i></h1>
                <h4 class="small"><?= htmlspecialchars($business['slogan']); ?></h4>
            </div>
        </div>
    </div>
</header>
<!-- /logo -->

<!-- navigation -->
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header visible-xs">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <i style="color: #9d9d9d;" class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="/"><?= htmlspecialchars($business['name']); ?></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="<?= Helper::getActive('index'); ?>"><a href="/"><i class="fa fa-home fa-lg fa-fw"></i>Home</a></li>
                <li class="dropdown <?= Helper::getActive('catalog'); ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Catalogue <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($categories as $key => $value) { ?>
                            <li class="text-capitalize">
                                <a href="/?page=catalog&category=<?= $value['id']; ?>">
                                    <?= htmlspecialchars($value['name']); ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="<?= Helper::getActive('about'); ?>"><a href="/?page=about"><i class="fa"></i><i class="fa fa-info-circle fa-lg fa-fw"></i>About Us</a></li>
                <li class="<?= Helper::getActive('contact'); ?>"><a href="/?page=contact"><i class="fa fa-mobile-phone fa-lg fa-fw"></i>Contact Us</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if (Login::isLoggedIn(Login::$_login_client)) { ?>
                    <li class="hidden-sm"><a href="#" class="btn disabled">Signed In as : <?= htmlspecialchars(Session::getSession(Login::$_client_name)); ?></a></li>
                    <li class="<?= Helper::getActive('orders'); ?>"><a href="/?page=orders"><i class="fa fa-book fa-lg fa-fw"></i>My Orders</a></li>
                    <li class="<?= Helper::getActive('logout'); ?>"><a href="/?page=logout"><i class="fa fa-sign-out fa-lg fa-fw"></i>Sign Out</a></li>
                <?php } else { ?>
                    <li class="<?= Helper::getActive('login'); ?>">
                        <a href="/?page=login"><i class="fa fa-sign-in fa-lg fa-fw"></i>Sign In / Sign Up</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<!-- /navigation -->