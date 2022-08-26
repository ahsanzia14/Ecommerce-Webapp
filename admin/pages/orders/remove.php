<?php
$id = Url::getParam('id');
if (!empty($id)) {

    $orderObj = new Order();
    $order = $orderObj->getOrder($id);

    if (!empty($order) && $order['status'] == 1) {


        if (Url::getParam('remove') == 1) {

            $catalogObj = new Catalog();
            $items = $orderObj->getOrderItems($id);

            if (!empty($items)) {
                foreach ($items as $item) {
                    $product = $catalogObj->getProduct($item['product']);
                    if ($order['status'] == 1) {
                        $catalogObj->updateProduct(array('qty' => $product['qty'] + $item['qty']), $item['product']);
                    }
                }
            }

            if ($orderObj->removeOrder($id)) {
                Session::setSession('removed', 'The order has been removed successfully.');
            } else {
                Session::setSession('removed', 'There was a problem removing this record. Please try again or contact administrator.');
            }
            Helper::redirect('/admin/?page=orders');
        }

        require_once('templates/_header.php');
        ?>

        <!-- main contents -->
        <div class="col-md-9 col-sm-8 col-xs-12">

            <!-- heading and specific links -->
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <h3 class="media-heading">Orders :: Remove</h3>
                </div>

                <div class="col-sm-6 col-xs-12">
                    <div class="btn-group btn-group-sm pull-right">
                        <?= Helper::getBackBtn(); ?>
                    </div>
                </div>
            </div>
            <!-- /heading and specific links -->

            <hr>

            <!--  -->
            <div class="row">
                <div class="col-xs-12">
                    <p>Are you sure to remove this record. There is no undo of this action.</p>
                    <p>
                        <a href="<?= Url::getCurrentUrl() . '&remove=1'; ?>">Yes</a> |
                        <a href="javascript:window.history.back()">No</a>
                    </p>
                </div>
            </div>
            <!-- / -->

        </div>
        <!-- /main contents -->

        <?php
    } else {
        Session::setSession('removed', 'Order in progress it can\'t be cancelled now.');
        Helper::redirect('/admin/?page=orders');
    }
}
require_once('templates/_footer.php');
?>
