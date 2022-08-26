<?php
if (Login::isLoggedIn(Login::$_login_admin)){
    Helper::redirect(Login::$_dashboard_admin);
}

$formObj = new Form();
$validatorObj = new Validation($formObj);

if ($formObj->isPost('email')){
    $adminObj = new Admin();
    if ($adminObj->isAdminUser($formObj->getPost('email'), $formObj->getPost('password'))){
        Login::loginAdmin($adminObj->_id, Url::getReferrerUrl());
    } else {
        $validatorObj->addToErrorArray('login');
    }
}
?>
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
    <link href="/css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <!--[endif]-->
</head>
<body style="background: #eeeeee;">

<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1><i>Control Panel</i></h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-2 col-md-10 col-sm-offset-2 col-sm-10">

            <form action="" method="post" class="form-horizontal form-condensed">

                <div class="form-group control-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <h3 class="help-block">Please Sign In</h3>
                        <div class="red"><?=$validatorObj->validate('login');?></div>
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="email" class="col-sm-3 control-label">Email *</label>
                    <div class="col-sm-5">
                        <input type="email" name="email" id="email" class="form-control" value="">
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="password" class="col-sm-3 control-label">Password *</label>
                    <div class="col-sm-5">
                        <input type="password" name="password" id="password" class="form-control" value="">
                    </div>
                </div>

                <div class="form-group control-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <input type="submit" class="btn btn-sm btn-primary" value="Sign In">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!--<script src="/js/bootstrap.min.js"></script>-->
</body>
</html>