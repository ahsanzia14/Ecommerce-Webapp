<?php
$id = Url::getParam('id');
if (!empty($id)) {

    $catalogObj = new Catalog();
    $product = $catalogObj->getProduct($id);

    if (!empty($product)) {

        if (Url::getParam('remove') == 1) {
            if ($catalogObj->removeProduct($id)) {
                unlink(CATALOG_DIR . DS . $product['image']);
                Session::setSession('removed', 'The product has been removed successfully.');
                Helper::redirect('/admin/?page=products');
            }
        }

        require_once('templates/_header.php');
        ?>

        <!-- main contents -->
        <div class="col-md-9 col-sm-8 col-xs-12">

            <!-- heading and specific links -->
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <h3 class="media-heading">Products :: Remove</h3>
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
    }
}
require_once('templates/_footer.php');
?>
