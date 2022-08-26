<?php require_once('_header.php');
Login::restrictUser();

$userObj = new User();
$user = $userObj->getUserById(Session::getSession(Login::$_login_client));

if (!empty($user)) {

$formObj = new Form();
$validatorObj = new Validation($formObj);

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
        'email'
    );

    $validatorObj->_required = array(
        'first_name',
        'last_name',
        'address_1',
        'town',
        'county',
        'post_code',
        'country',
        'email'
    );

    $validatorObj->_special = array(
        'email' => 'email'
    );

    if ($validatorObj->isValid()) {

        if ($userObj->updateUser($user['id'], $validatorObj->_post)) {
            Helper::redirect('?page=summary');
        } else {
            $out = '<p class="red">There was a problem updating your details. ';
            $out .= 'Please try again or contact Administrator.</p>';
        }
    }
}
?>

<!-- show case -->
<div class="col-md-9 col-sm-8 col-xs-12">
    <div class="row">
        <div class="col-xs-12">
            <h3>Checkout</h3>
            <hr>
        </div>
    </div>

    <p class="help-block">Please Check your Details first and then Click <strong>Next</strong></p>
    <?= !empty($out) ? $out : null; ?>

    <!-- checkout form -->
    <div class="row">
        <div class="col-md-8 col-sm-10 col-xs-12">
            <form action="" method="post" class="form-horizontal form-condensed">
                <div class="form-group control-group">
                    <label for="first_name" class="col-sm-4 control-label">First Name *</label>
                    <div class="col-sm-8">
                        <?= $validatorObj->validate('first_name'); ?>
                        <input type="text" name="first_name" id="first_name" class="form-control"
                               value="<?= $formObj->stickyText('first_name', $user['first_name']); ?>">
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="last_name" class="col-sm-4 control-label">Last Name *</label>
                    <div class="col-sm-8">
                        <?= $validatorObj->validate('last_name'); ?>
                        <input type="text" name="last_name" id="last_name" class="form-control"
                               value="<?= $formObj->stickyText('last_name', $user['last_name']); ?>">
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="address_1" class="col-sm-4 control-label">Address 1 *</label>
                    <div class="col-sm-8">
                        <?= $validatorObj->validate('address_1'); ?>
                        <input type="text" name="address_1" id="address_1" class="form-control"
                               value="<?= $formObj->stickyText('address_1', $user['address_1']); ?>">
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="address_2" class="col-sm-4 control-label">Address 2</label>
                    <div class="col-sm-8">
                        <?= $validatorObj->validate('address_2'); ?>
                        <input type="text" name="address_2" id="address_2" class="form-control"
                               value="<?= $formObj->stickyText('address_2', $user['address_2']); ?>">
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="town" class="col-sm-4 control-label">City *</label>
                    <div class="col-sm-8">
                        <?= $validatorObj->validate('town'); ?>
                        <input type="text" name="town" id="town" class="form-control"
                               value="<?= $formObj->stickyText('town', $user['town']); ?>">
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="county" class="col-sm-4 control-label">State/Province *</label>
                    <div class="col-sm-8">
                        <?= $validatorObj->validate('county'); ?>
                        <input type="text" name="county" id="county" class="form-control"
                               value="<?= $formObj->stickyText('county', $user['county']); ?>">
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="post_code" class="col-sm-4 control-label">Post Code *</label>
                    <div class="col-sm-8">
                        <?= $validatorObj->validate('post_code'); ?>
                        <input type="text" name="post_code" id="post_code" class="form-control"
                               value="<?= $formObj->stickyText('post_code', $user['post_code']); ?>">
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="country" class="col-sm-4 control-label">Country *</label>
                    <div class="col-sm-8">
                        <?= $validatorObj->validate('country'); ?>
                        <?= $formObj->getCountriesList($user['country']); ?>
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="email" class="col-sm-4 control-label">Email *</label>
                    <div class="col-sm-8">
                        <?= $validatorObj->validate('email'); ?>
                        <input type="text" name="email" id="email" class="form-control"
                               value="<?= $formObj->stickyText('email', $user['email']); ?>">
                    </div>
                </div>

                <div class="text-right">
                    <input type="submit" class="btn btn-primary" value="Checkout">
                </div>

            </form>

        </div>
    </div>
    <!-- /contact form -->
    <?php } else {
        Helper::redirect('error.php');
    }
    ?>
</div>
<!-- /show case -->
<?php require_once('_footer.php'); ?>