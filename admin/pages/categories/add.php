<?php
$formObj = new Form();
$validatorObj = new Validation($formObj);

if ($formObj->isPost('name')) {

    $validatorObj->_expected = array('name');
    $validatorObj->_required = array('name');

    if ($validatorObj->isValid()) {
        $catalogObj = new Catalog();
        if ($catalogObj->addCategory($validatorObj->_post)) {
            Session::setSession('added', 'Category has been added successfully.');
        } else {
            Session::setSession('added', 'There was a problem inserting this record. Please try again or contact administrator.');
        }
        Helper::redirect('/admin/?page=categories');
    }
}

require_once('templates/_header.php');
?>
    <!-- main contents -->
    <div class="col-md-9 col-sm-8 col-xs-12">

        <!-- heading and specific links -->
        <div class="row">
            <div class="col-sm-8 col-xs-10">
                <h3 class="media-heading">Categories :: Add</h3>
            </div>

            <div class="col-sm-4 col-xs-2">
                <div class="btn-group btn-group-sm pull-right">
                    <?= Helper::getBackBtn(); ?>
                </div>
            </div>
        </div>
        <!-- /heading and specific links -->

        <hr>

        <!-- form -->
        <div class="row">
            <div class="col-lg-offset-1 col-lg-8 col-md-10 col-sm-12">

                <form action="" method="post" class="form-horizontal form-condensed">

                    <div class="form-group control-group">
                        <label for="name" class="col-sm-4 control-label">Name *</label>
                        <div class="col-sm-8">
                            <?= $validatorObj->validate('name'); ?>
                            <input type="text" id="name" name="name" class="form-control"
                                   value="<?= $formObj->stickyText('name'); ?>"/>
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <input type="submit" id="btn" class="btn btn-sm btn-primary" value="Add">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- /main contents -->

<?php require_once('templates/_footer.php'); ?>