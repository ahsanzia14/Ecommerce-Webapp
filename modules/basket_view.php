<?php
require_once('../inc/autoload.php');

$session = Session::getSession('basket');
$basketObj = new Basket();
$items = array();

if (!empty($session)){
    $catalogObj = new Catalog();
    foreach ($session as $key => $value){
        $items[$key] = $catalogObj->getProduct($key);
    }
}

?>

<?php if (!empty($items)) { ?>

    <form action="" method="post" id="frm_basket">
        <table class="table table-striped table-bordered table-condensed">
            <thead>
            <tr>
                <th class="col-md-5 col-sm-5 col-xs-5">Name</th>
                <th class="col-md-2 col-sm-2 col-xs-2">Quantity</th>
                <th class="col-md-3 col-sm-3 col-xs-3">Price</th>
                <th class="col-md-2 col-sm-2 col-xs-2">Remove</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($items as $item) { ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']); ?></td>
                    <td>
                        <input
                            type="number"
                            name="quantity-<?= $item['id']; ?>"
                            id="quantity-<?= $item['id']; ?>"
                            class="form-control input-sm" min="1"
                            value="<?= $session[$item['id']]['quantity']; ?>">
                    </td>
                    <td><?= Catalog::$_currency.' '.number_format($basketObj->itemTotal($item['price'], $session[$item['id']]['quantity']), 2); ?></td>
                    <td><?= Basket::removeButton($item['id']); ?></td>
                </tr>
            <?php } ?>

            <?php if ($basketObj->_vat_rate != 0) { ?>
                <tr>
                    <td colspan="2">Sub-Total</td>
                    <td colspan="2"><?= Catalog::$_currency.' '.number_format($basketObj->_sub_total, 2); ?></td>
                </tr>

                <tr>
                    <td colspan="2">VAT (<?= number_format($basketObj->_vat_rate, 2); ?> %)</td>
                    <td colspan="2"><?= Catalog::$_currency.' '.number_format($basketObj->_vat, 2); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td colspan="2">
                    <strong><?= Catalog::$_currency.' '.number_format($basketObj->_total, 2); ?></strong>
                </td>
            </tr>
            </tbody>
        </table>

        <span class="update_basket btn btn-sm btn-primary">Update</span>
        <div class="pull-right">
            <a href="/?page=checkout" class="btn btn-sm btn-success">Checkout</a>
        </div>
    </form>

<?php } else { ?>
    <p>Your Basket is currently Empty.</p>
<?php } ?>
