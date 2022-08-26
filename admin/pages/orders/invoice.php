<?php
Login::restrictAdmin();
$id = Url::getParam('id');
if (!empty($id)) {
    $orderObj = new Order();
    $order = $orderObj->getOrder($id);
    if (!empty($order)) {

        $items = $orderObj->getOrderItems($id);

        $catalogObj = new Catalog();
        $basketObj = new Basket();

        $userObj = new User();
        $user = $userObj->getUserById($order['client']);

        $countryObj = new Country();
        $country = $countryObj->getCountry($user['country']);

        $businessObj = new Business();
        $business = $businessObj->getBusiness();
        ?>

        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Ecommerce website project</title>
            <meta name="description" content="Ecommerce website project"/>
            <meta name="keywords" content="Ecommerce website project"/>
            <!--<meta http-equiv="imagetoolbar" content="no" />-->
            <link href="/css/invoice.css" rel="stylesheet" type="text/css"/>
        </head>
        <body>
        <div id="wrapper">
            <h1>Invoice</h1>
            <div style="float: left; width: 50%;">
                <p><strong>To:</strong>
                    <?= Session::getSession(Login::$_client_name); ?><br>
                    <?= $user['address_1']; ?><br>
                    <?= (!empty($user['address_2'])) ? $user['address_2'] : ''; ?><br>
                    <?= $user['town']; ?><br>
                    <?= $user['county']; ?><br>
                    <?= $country['name']; ?>
                </p>
            </div>

            <div style="float: right; width: 50%; text-align: right;">
                <p><strong><?= $business['name']; ?></strong><br>
                    <?= nl2br($business['address']); ?><br>
                    <?= $business['telephone']; ?><br>
                    <?= $business['email']; ?><br>
                    <?= $business['website']; ?>
                </p>
            </div>

            <div class="dev">&nbsp;</div>

            <table cellpadding="0" cellspacing="0" border="0" class="tbl_repeat">
                <tr>
                    <th>Item</th>
                    <th class="ta_r">Quantity</th>
                    <th class="ta_r col_15">Price</th>
                </tr>

                <?php foreach ($items as $key => $item) { ?>
                    <tr>
                        <td><?= $catalogObj->getProduct($item['product'])['name']; ?></td>
                        <td class="ta_r"><?= $item['qty']; ?></td>
                        <td class="ta_r col_15">
                            <?= Catalog::$_currency . ' ' . number_format($basketObj->itemTotal($item['price'], $item['qty']), 2); ?>
                        </td>
                    </tr>
                <?php } ?>

                <?php if ($order['vat_rate'] != 0) { ?>
                    <tr>
                        <td colspan="2" class="br_td">Sub-Total :</td>
                        <td class="ta_r br_td"><?= Catalog::$_currency . ' ' . number_format($order['subtotal'], 2); ?></td>
                    </tr>

                    <tr>
                        <td colspan="2" class="br_td">VAT (<?= $order['vat_rate']; ?>%) :</td>
                        <td class="ta_r br_td"><?= Catalog::$_currency . ' ' . number_format($order['vat'], 2); ?></td>
                    </tr>
                <?php } ?>

                <tr>
                    <td colspan="2" class="br_td"><strong>Total :</strong></td>
                    <td class="ta_r br_td">
                        <strong><?= Catalog::$_currency . ' ' . number_format($order['total'], 2); ?></strong></td>
                </tr>

            </table>

            <div class="dev br_td">&nbsp;</div>

            <p><a href="#" onclick="window.print(); return false;">Print this Invoice</a></p>

        </div>
        </body>
        </html>

        <?php
    }
}
?>