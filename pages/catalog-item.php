<?php
$product_id = Url::getParam('id');

if (!empty($product_id)) {

    $catalog = new Catalog();
    $product = $catalog->getProduct($product_id);

    if (!empty($product)) {
        $category = $catalog->getCategory($product['category']);

        require_once('_header.php');

        $image = (!empty($product['image'])) ? $product['image'] : null;

        if (!empty($image)) {
            $image = Catalog::$_image_path . $image;

            $width = Helper::getImageSize($image, 0);
            $width = ($width > 242) ? 242 : $width;
        } else {
            $width = 242;
            $image = Catalog::$_image_path . 'unavailable.png';
        }
        ?>

        <!-- show case -->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <h3>Catalogue :: <?= htmlspecialchars($category['name']); ?></h3>
                    <hr>
                </div>
            </div>

            <!-- products -->
            <div class="row">

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="thumbnail">
                        <img src="<?= $image; ?>" alt="<?= htmlspecialchars($product['name']); ?>"
                             width="<?= $width; ?>">
                    </div>
                </div>

                <div class="col-md-8 col-sm-6 col-xs-12">
                    <div class="caption">
                        <h4><?= htmlspecialchars($product['name']); ?></h4>
                        <p class="text-justify"><?= nl2br(htmlspecialchars($product['description'])); ?></p>
                        <p>
                            <strong>Price: <?= Catalog::$_currency . ' ' . htmlspecialchars($product['price']); ?></strong>
                        </p>
                        <p><?= Basket::buttonActive($product_id); ?></p>
                    </div>
                    <hr>
                   <?=Helper::getBackBtn();?>
                </div>

            </div>
            <!-- /products -->

        </div>
        <?php

        require_once('_footer.php');
    } else {
        require_once('error.php');
    }
}