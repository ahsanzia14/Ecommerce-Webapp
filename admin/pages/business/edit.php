<?php
$businessObj = new Business();
$business = $businessObj->getBusiness();

if (!empty($business)) {

    $formObj = new Form();
    $validatorObj = new Validation($formObj);

    if ($formObj->isPost('name')) {

        $validatorObj->_expected = array(
            'name',
            'slogan', 
            'address',
            'telephone',
            'email',
            'website',
            'vat_rate',
            'about'
        );

        $validatorObj->_required = array(
            'name',
            'slogan',
            'address',
            'telephone',
            'email',
            'vat_rate',
            'about',
        );

        $validatorObj->_special = array(
            'email' => 'email'
        );

        $values = $formObj->getPostArray($validatorObj->_expected);

        if ($validatorObj->isValid()) {
            if ($businessObj->updateBusiness($values)) {
                Session::setSession('edited', 'Record has been updated successfully.');
            } else {
                Session::setSession('edited', 'There was a problem updating this record.Please try again or contact administrator.');
            }
            Helper::redirect('/admin/?page=business');
        }
    }
    require_once('templates/_header.php');
    ?>

    <!-- main contents -->
    <div class="col-md-9 col-sm-8 col-xs-12">

        <!-- heading and specific links -->
        <div class="row">
            <div class="col-sm-8 col-xs-10">
                <h3 class="media-heading">Business :: Edit</h3>
            </div>

            <div class="col-sm-4 col-xs-2">
                <div class="pull-right">
                    <a href="/admin/?page=business&action=account" class="btn btn-sm btn-primary">Account Info</a>
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
                        <label for="name" class="col-sm-4 control-label">Name *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('name'); ?>
                            <input type="text" id="name" name="name" class="form-control"
                                   value="<?= $formObj->stickyText('name', $business['name']); ?>"/>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="slogan" class="col-sm-4 control-label">Name *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('slogan'); ?>
                            <input type="text" id="slogan" name="slogan" class="form-control"
                                   value="<?= $formObj->stickyText('slogan', $business['slogan']); ?>"/>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="address" class="col-sm-4 control-label">Address *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('address'); ?>
                            <textarea name="address" id="address" class="form-control" cols=""
                                      rows="5"><?= $formObj->stickyText('address', $business['address']); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="telephone" class="col-sm-4 control-label">Telephone *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('telephone'); ?>
                            <input type="tel" name="telephone" id="telephone" class="form-control"
                                   value="<?= $formObj->stickyText('telephone', $business['telephone']); ?>"/>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="email" class="col-sm-4 control-label">Email *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('email'); ?>
                            <input type="email" min="0" name="email" id="email" class="form-control"
                                   value="<?= $formObj->stickyText('email', $business['email']); ?>"/>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="website" class="col-sm-4 control-label">Website</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('website'); ?>
                            <input type="text" id="website" name="website" class="form-control"
                                   value="<?= $formObj->stickyText('website', $business['website']); ?>"/>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="vat_rate" class="col-sm-4 control-label">VAT Rate *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('vat_rate'); ?>
                            <input type="text" name="vat_rate" id="vat_rate" class="form-control"
                                   value="<?= $formObj->stickyText('vat_rate', $business['vat_rate']); ?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="about" class="col-sm-4 control-label">About *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('about'); ?>
                            <textarea name="about" id="about" class="form-control" cols=""
                                      rows="5"><?= $formObj->stickyText('about', $business['about']); ?></textarea>
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
    require_once('templates/_footer.php');
}
?>