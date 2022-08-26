<?php
$id = Url::getParam('id');

if (!empty($id)) {

    $userObj = new User();
    $user = $userObj->getUserById($id);

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

            $duplicate = $userObj->getUserByEmail($formObj->getPost('email'));
            if (!empty($duplicate) && $duplicate['id'] != $user['id']) {
                Session::setSession('edited', 'Provided email address already registered by other client.');
                Helper::redirect('/admin/?page=clients');
            }

            if ($validatorObj->isValid()) {

                if ($userObj->updateUser($user['id'], $validatorObj->_post)) {
                    Session::setSession('edited', 'Client has been updated successfully.');
                } else {
                    Session::setSession('edited', 'There was a problem updating this record.Please try again or contact administrator.');
                }
                Helper::redirect('/admin/?page=clients');
            }
        }
        require_once('templates/_header.php');
        ?>

        <!-- main contents -->
        <div class="col-md-9 col-sm-8 col-xs-12">

            <!-- heading and specific links -->
            <div class="row">
                <div class="col-sm-8 col-xs-10">
                    <h3 class="media-heading">Clients :: Edit</h3>
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
                            <label for="first_name" class="col-sm-4 control-label">First Name *</label>
                            <div class="col-sm-8">
                                <?= $validatorObj->validate('first_name'); ?>
                                <input type="text" id="first_name" name="first_name" class="form-control"
                                       value="<?= $formObj->stickyText('first_name', $user['first_name']); ?>"/>
                            </div>
                        </div>

                        <div class="form-group control-group">
                            <label for="last_name" class="col-sm-4 control-label">Last Name *</label>
                            <div class="col-sm-8">
                                <?= $validatorObj->validate('last_name'); ?>
                                <input type="text" id="last_name" name="last_name" class="form-control"
                                       value="<?= $formObj->stickyText('last_name', $user['last_name']); ?>"/>
                            </div>
                        </div>

                        <div class="form-group control-group">
                            <label for="address_1" class="col-sm-4 control-label">Address 1 *</label>
                            <div class="col-sm-8">
                                <?= $validatorObj->validate('address_1'); ?>
                                <input type="text" name="address_1" id="address_1" class="form-control"
                                       value="<?= $formObj->stickyText('address_1', $user['address_1']); ?>"/>
                            </div>
                        </div>

                        <div class="form-group control-group">
                            <label for="address_2" class="col-sm-4 control-label">Address 2</label>
                            <div class="col-sm-8">
                                <?= $validatorObj->validate('address_2'); ?>
                                <input type="text" name="address_2" id="address_2" class="form-control"
                                       value="<?= $formObj->stickyText('address_2', $user['address_2']); ?>"/>
                            </div>
                        </div>

                        <div class="form-group control-group">
                            <label for="town" class="col-sm-4 control-label">City *</label>
                            <div class="col-sm-8">
                                <?= $validatorObj->validate('town'); ?>
                                <input type="text" name="town" id="town" class="form-control"
                                       value="<?= $formObj->stickyText('town', $user['town']); ?>"/>
                            </div>
                        </div>


                        <div class="form-group control-group">
                            <label for="county" class="col-sm-4 control-label">State/Province *</label>
                            <div class="col-sm-8">
                                <?= $validatorObj->validate('county'); ?>
                                <input type="text" name="county" id="county" class="form-control"
                                       value="<?= $formObj->stickyText('county', $user['county']); ?>"/>
                            </div>
                        </div>

                        <div class="form-group control-group">
                            <label for="post_code" class="col-sm-4 control-label">Post Code *</label>
                            <div class="col-sm-8">
                                <?= $validatorObj->validate('post_code'); ?>
                                <input type="text" name="post_code" id="post_code" class="form-control"
                                       value="<?= $formObj->stickyText('post_code', $user['post_code']); ?>"/>
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
                            <label for="email" class="col-sm-4 control-label">Email Address *</label>
                            <div class="col-sm-8">
                                <?= $validatorObj->validate('email'); ?>
                                <input type="email" min="0" name="email" id="email" class="form-control"
                                       value="<?= $formObj->stickyText('email', $user['email']); ?>"/>
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
            <!-- /form -->
        </div>

        <?php
        require_once('templates/_footer.php');
    }
}
?>