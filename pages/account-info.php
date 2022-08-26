<?php
Session::cleanSession('basket');
Session::cleanSession('trans_type');

require_once('_header.php');

$accountInfo = $businessObj->getAccountInfo();

if (!empty($accountInfo)) {

    ?>
    <!-- show case -->
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <h3>Thanks for Shopping</h3>
                <hr>
            </div>
        </div>

        <!-- about us -->
        <div class="row">

            <div class="col-xs-12">
                <p class="text-justify">Thanks for placing your order. We will proceed as soon as your payment is confirmed.</p>
                <p>Our Account Info is shown below...</p>

                <dl class="dl-horizontal">
                    <dt>Bank Name :</dt>
                    <dd><?=htmlspecialchars($accountInfo['bank_name']);?></dd>
                    <dt>Branch :</dt>
                    <dd><?=htmlspecialchars($accountInfo['branch']);?></dd>
                    <dt>City :</dt>
                    <dd><?=htmlspecialchars($accountInfo['city']);?></dd>
                    <dt>Country :</dt>
                    <dd><?=htmlspecialchars($accountInfo['name']);?></dd>
                    <dt>Swift / BIC :</dt>
                    <dd><?=htmlspecialchars($accountInfo['swift_bic']);?></dd>
                    <dt>Account Owner :</dt>
                    <dd><?=htmlspecialchars($accountInfo['acc_owner']);?></dd>
                    <dt>Account # :</dt>
                    <dd><?=htmlspecialchars($accountInfo['acc_no']);?></dd>
                    <dt>IBAN # : </dt>
                    <dd><?=$accountInfo['iban'];?></dd>
                </dl>
            </div>

        </div>
        <!-- /about us -->

    </div>
    <!-- /show case -->
    <?php
}
require_once('_footer.php'); ?>