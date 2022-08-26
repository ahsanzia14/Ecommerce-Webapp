<?php
Login::restrictUser();

$token = mt_rand();
$token_hash = Login::takeHash($token);
Session::setSession('token', $token_hash);

$items = array();
$session = Session::getSession('basket');


if (!empty($session)) {
    $basketObj = new Basket();

    $catalogObj = new Catalog();
    foreach ($session as $key => $value) {
        $items[$key] = $catalogObj->getProduct($key);
    }
}
require_once('_header.php');
?>

    <!-- show case -->
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <h3>Order Summary</h3>
                <hr>
            </div>
        </div>

        <?php if (!empty($items)) { ?>
            <!-- main content -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <div id="big_basket">
                            <form action="" method="post">
                                <table class="table table-striped table-bordered table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php foreach ($items as $key => $item) { ?>
                                        <tr>
                                            <td><?= $item['name']; ?></td>
                                            <td><?= $session[$item['id']]['quantity']; ?></td>
                                            <td>
                                                <?= Catalog::$_currency . ' ' . number_format($basketObj->itemTotal($item['price'], $session[$item['id']]['quantity']), 2); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="2">Sub-Total</td>
                                        <td colspan="2"><?= Catalog::$_currency . ' ' . number_format($basketObj->_sub_total, 2); ?></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">VAT (<?= $basketObj->_vat_rate; ?> %)</td>
                                        <td colspan="2"><?= Catalog::$_currency . ' ' . number_format($basketObj->_vat, 2); ?></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2"><strong>Total</strong></td>
                                        <td colspan="2">
                                            <strong><?= Catalog::$_currency . ' ' . number_format($basketObj->_total, 2); ?></strong>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="pull-right paypal" id="<?= $token; ?>">
                                    <span class="btn btn-sm btn-success">Proceed to PayPal</span>
                                </div>

                                <div class="pull-right bank" id="<?= $token; ?>">
                                    <span class="btn btn-sm btn-success">Through Bank</span>
                                </div>

                                <a href="/?page=basket" class="btn btn-sm btn-primary">Amend Order</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /main content -->
            <div class="dn">
                <img src="/images/loadinfo.net.gif" alt="Proceeding to PayPal">
            </div>
            <div id="frm_pp"></div>
        <?php } else { ?>
            <p>Your basket is currently empty.</p>
        <?php } ?>

    </div>
    <!-- /show case -->

<?php require_once('_footer.php'); ?>