<?php
$businessObj = new Business();
$accountInfo = $businessObj->getAccountInfo();

if (!empty($accountInfo)) {
    $formObj = new Form();
    $validatorObj = new Validation($formObj);

    if ($formObj->isPost('bank_name')) {

        $validatorObj->_required = array(
            'bank_name',
            'branch',
            'city',
            'country',
            'routing_no',
            'swift_bic',
            'acc_owner',
            'acc_no',
            'iban'
        );

        if ($validatorObj->isValid()) {

            if ($businessObj->updateAccountInfo($validatorObj->_post)) {
                Session::setSession('edited', 'Account Info has been updated successfully.');
            } else {
                Session::setSession('edited', 'There was a problem updating this record.Please try again or contact administrator.');
            }
            Helper::redirect('/admin/?page=business&action=account');
        }
    }

    require_once('templates/_header.php');
    ?>

    <!-- main contents -->
    <div class="col-md-9 col-sm-8 col-xs-12">

        <!-- heading and specific links -->
        <div class="row">
            <div class="col-sm-8 col-xs-10">
                <h3 class="media-heading">Account :: Edit</h3>
            </div>

            <div class="col-sm-4 col-xs-2">
                <div class="pull-right">
                    <?=Helper::getBackBtn();?>
                </div>
            </div>
        </div>
        <!-- /heading and specific links -->

        <hr>

        <!-- messages -->
        <p class="red"><?= Session::getSession('edited') ?></p>
        <?= Session::cleanSession('edited'); ?>
        <!-- /messages -->

        <!-- form -->
        <div class="row">

            <div class="col-lg-offset-1 col-lg-8 col-md-10 col-sm-12">

                <form action="" method="post" class="form-horizontal form-condensed">

                    <div class="form-group control-group">
                        <label for="bank_name" class="col-sm-4 control-label">Bank Name *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('bank_name'); ?>
                            <input type="text" id="bank_name" name="bank_name" class="form-control"
                                   value="<?= $formObj->stickyText('bank_name', $accountInfo['bank_name']); ?>"/>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="branch" class="col-sm-4 control-label">Branch *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('branch'); ?>
                            <input type="text" min="0" name="branch" id="branch" class="form-control"
                                   value="<?= $formObj->stickyText('branch', $accountInfo['branch']); ?>"/>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="city" class="col-sm-4 control-label">City *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('city'); ?>
                            <input type="text" name="city" id="city" class="form-control"
                                   value="<?= $formObj->stickyText('city', $accountInfo['city']); ?>"/>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="country" class="col-sm-4 control-label">Country *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('country'); ?>
                            <?= $formObj->getCountriesList($accountInfo['country']); ?>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="routing_no" class="col-sm-4 control-label">Routing # *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('routing_no'); ?>
                            <input type="text" id="routing_no" name="routing_no" class="form-control"
                                   value="<?= $formObj->stickyText('routing_no', $accountInfo['routing_no']); ?>"/>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="swift_bic" class="col-sm-4 control-label">SWIFT / BIC *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('swift_bic'); ?>
                            <input type="text" name="swift_bic" id="swift_bic" class="form-control"
                                   value="<?= $formObj->stickyText('swift_bic', $accountInfo['swift_bic']); ?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="acc_owner" class="col-sm-4 control-label">Account Owner *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('acc_owner'); ?>
                            <input type="text" name="acc_owner" id="acc_owner" class="form-control"
                                   value="<?= $formObj->stickyText('acc_owner', $accountInfo['acc_owner']); ?>"/>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="acc_no" class="col-sm-4 control-label">Account # *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('acc_no'); ?>
                            <input type="text" name="acc_no" id="acc_no" class="form-control"
                                   value="<?= $formObj->stickyText('acc_no', $accountInfo['acc_no']); ?>"/>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="iban" class="col-sm-4 control-label">IBAN *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('iban'); ?>
                            <input type="text" name="iban" id="iban" class="form-control"
                                   value="<?= $formObj->stickyText('iban', $accountInfo['iban']); ?>"/>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <input type="submit" id="btn" class="btn btn-sm btn-primary" value="Update">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <?php
}
require_once('templates/_footer.php');
?>