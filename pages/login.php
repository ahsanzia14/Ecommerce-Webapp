<?php
if (Login::isLoggedIn(Login::$_login_client)) {
    Helper::redirect(Login::$_dashboard_front);
}

require_once('_header.php');

$formObj = new Form();
$validatorObj = new Validation($formObj);
$userObj = new User();

// Login
if ($formObj->isPost('login_email')) {

    if ($userObj->verifyUser($formObj->getPost('login_email'), $formObj->getPost('login_password'))) {
        Login::loginFront($userObj->_id, Url::getReferrerUrl());
    } else {
        $validatorObj->addToErrorArray('login');
    }
}

// Registration
if ($formObj->isPost('first_name')) {

    $validatorObj->_expected = array(
        'first_name',
        'last_name',
        'address_1',
        'address_2',
        'town',
        'county',
        'post_code',
        'country',
        'email',
        'password',
        'confirm_password'
    );

    $validatorObj->_required = array(
        'first_name',
        'last_name',
        'address_1',
        'town',
        'county',
        'post_code',
        'country',
        'email',
        'password',
        'confirm_password'
    );

    $validatorObj->_special = array(
        'email' => 'email'
    );

    $validatorObj->_post_remove = array(
        'confirm_password'
    );

    $validatorObj->_post_format = array(
        'password' => 'password'
    );

    $password = $formObj->getPost('password');
    $confirm_password = $formObj->getPost('confirm_password');
    if (!empty($password) && !empty($confirm_password) && $password != $confirm_password) {
        $validatorObj->addToErrorArray('password_mismatch');
    }

    $email = $formObj->getPost('email');
    $user = $userObj->getUserByEmail($email);

    if (!empty($user)) {
        $validatorObj->addToErrorArray('duplicate_email');
    }

    if ($validatorObj->isValid()) {

        $validatorObj->_post['hash'] = mt_rand() . date('YmdHis') . mt_rand();
        $validatorObj->_post['date'] = Helper::setDate();

        if ($userObj->addUser($validatorObj->_post, $formObj->getPost('password'))) {
            Helper::redirect('/?page=registered');
        } else {
            Helper::redirect('/?page=registered-failed');
        };
    }
}

?>

    <!-- show case -->
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <h3>Sign In</h3>
                <hr>
            </div>
        </div>

        <!--  login form -->
        <div class="row">
            <div class="col-md-8 col-sm-10 col-xs-12">
                <form action="" method="post" class="form-horizontal form-condensed">
                    <div class="form-group control-group">
                        <label for="login_email" class="col-sm-4 control-label">Email * </label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('login'); ?>
                            <input type="email" name="login_email" id="login_email" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="login_password" class="col-sm-4 control-label">Password * </label>
                        <div class="col-sm-8">
                            <input type="password" name="login_password" id="login_password" class="form-control"
                                   value="">
                        </div>
                    </div>

                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" value="Sign In">
                    </div>
                </form>

            </div>
        </div>
        <!-- /contact us -->
        <div class="clearfix">&nbsp;</div>
        <!-- contact form -->
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <legend>Not Registered Yet!</legend>
                <form action="" method="post" class="form-horizontal form-condensed">
                    <div class="form-group control-group">
                        <label for="first_name" class="col-sm-4 control-label">First Name *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('first_name'); ?>
                            <input type="text" name="first_name" id="first_name" class="form-control"
                                   value="<?= $formObj->stickyText('first_name'); ?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="last_name" class="col-sm-4 control-label">Last Name *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('last_name'); ?>
                            <input type="text" name="last_name" id="last_name" class="form-control"
                                   value="<?= $formObj->stickyText('last_name'); ?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="address_1" class="col-sm-4 control-label">Address 1 *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('address_1'); ?>
                            <input type="text" name="address_1" id="address_1" class="form-control"
                                   value="<?= $formObj->stickyText('address_1'); ?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="address_2" class="col-sm-4 control-label">Address 2</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('address_2'); ?>
                            <input type="text" name="address_2" id="address_2" class="form-control"
                                   value="<?= $formObj->stickyText('address_2'); ?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="town" class="col-sm-4 control-label">City *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('town'); ?>
                            <input type="text" name="town" id="town" class="form-control"
                                   value="<?= $formObj->stickyText('town'); ?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="county" class="col-sm-4 control-label">State/Province *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('county'); ?>
                            <input type="text" name="county" id="county" class="form-control"
                                   value="<?= $formObj->stickyText('county'); ?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="post_code" class="col-sm-4 control-label">Post Code *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('post_code'); ?>
                            <input type="text" name="post_code" id="post_code" class="form-control"
                                   value="<?= $formObj->stickyText('post_code'); ?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="country" class="col-sm-4 control-label">Country *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('country'); ?>
                            <?= $formObj->getCountriesList(); ?>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="email" class="col-sm-4 control-label">Email *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('email'); ?>
                            <?= $validatorObj->validate('duplicate_email'); ?>
                            <input type="text" name="email" id="email" class="form-control"
                                   value="<?= $formObj->stickyText('email'); ?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="password" class="col-sm-4 control-label">Password * </label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('password'); ?>
                            <?= $validatorObj->validate('password_mismatch'); ?>
                            <input type="password" name="password" id="password" class="form-control"
                                   value="<?= $formObj->stickyText('password'); ?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="confirm_password" class="col-sm-4 control-label">Confirm Password * </label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('confirm_password'); ?>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                   value="<?= $formObj->stickyText('confirm_password'); ?>">
                        </div>
                    </div>

                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" value="Register">
                    </div>

                </form>

            </div>
        </div>
        <!-- /contact form -->

    </div>
    <!-- /show case -->

<?php require_once('_footer.php'); ?>