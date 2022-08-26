<?php
$formObj = new Form();
$validatorObj = new Validation($formObj);

if ($formObj->isPost('name')){
    $validatorObj->_expected = array(
        'name', 'email', 'subject', 'message'
    );

    $validatorObj->_required = array(
        'name', 'email', 'subject', 'message'
    );

    $validatorObj->_special = array('email');

    if ($validatorObj->isValid()){

        $emailObj = new Email();
        if ($emailObj->process(2, $validatorObj->_post)){
            Session::setSession('emailSent', 'Email have been sent successfully.');
        } else {
            Session::setSession('emailSent', 'There was problem in sending email. Please try again.');
        }
        Helper::redirect(Url::getCurrentUrl());
    }
}
require_once('_header.php');
?>

    <!-- show case -->
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <h3>Contact Us</h3>
                <hr>
            </div>
        </div>

        <!-- contact us -->
        <div class="row">

            <div class="col-xs-12">

                <dl class="dl-horizontal">
                    <dt>Company Name</dt>
                    <dd><?=htmlspecialchars($business['name']);?></dd>
                    <p>
                    <dt>Main Office</dt>
                    <dd><?=nl2br(htmlspecialchars($business['address']));?></dd>
                    </p>
                    <dt>Telephone #</dt>
                    <dd><?=htmlspecialchars($business['telephone']);?></dd>
                    <dt>Email ID</dt>
                    <dd><a href="mailto:<?= $business['email']; ?>"><?=htmlspecialchars($business['email']);?></a></dd>
                    <dt>Website</dt>
                    <dd><a href="<?=SITE_URL;?>"><?=htmlspecialchars($business['website']);?></a></dd>
                </dl>
            </div>

        </div>
        <!-- /contact us -->
        <div class="clearfix">&nbsp;</div>
        <!-- contact form -->
        <div class="row">
            <div class="col-md-8 col-sm-10 col-xs-12">
                <legend>Send Us Email</legend>

                <?php
                    echo '<p class="red">'.Session::getSession('emailSent').'</p>';
                    Session::cleanSession('emailSent');
                ?>

                <form action="" method="post" class="form-horizontal form-condensed">
                    <div class="form-group control-group">
                        <label for="name" class="col-sm-4 control-label">Full Name *</label>
                        <div class="col-sm-8">
                            <?=$validatorObj->validate('name');?>
                            <input type="text" name="name" id="name" class="form-control" value="<?=$formObj->stickyText('name');?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="email" class="col-sm-4 control-label">Your Email *</label>
                        <div class="col-sm-8">
                            <?=$validatorObj->validate('email');?>
                            <input type="email" name="email" id="email" class="form-control" value="<?=$formObj->stickyText('email');?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="subject" class="col-sm-4 control-label">Subject *</label>
                        <div class="col-sm-8">
                            <?=$validatorObj->validate('subject');?>
                            <input type="text" name="subject" id="subject" class="form-control" value="<?=$formObj->stickyText('subject');?>">
                        </div>
                    </div>

                    <div class="form-group control-group">
                        <label for="message" class="col-sm-4 control-label">Message *</label>
                        <div class="col-sm-8">
                            <?=$validatorObj->validate('message');?>
                            <textarea type="message" name="message" id="message" rows="5"
                                      class="form-control"><?=$formObj->stickyText('message');?></textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" value="Send">
                    </div>
                </form>

            </div>
        </div>
        <!-- /contact form -->

    </div>
    <!-- /show case -->

<?php require_once('_footer.php'); ?>