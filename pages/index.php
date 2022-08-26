<?php
$catalogObj = new Catalog();
$products = $catalogObj->getAllProducts();

require_once('_header.php');
?>

<!-- show case -->
<div class="col-md-9 col-sm-8 col-xs-12">
    <div class="row">
        <div class="col-xs-12">
            <h3>Products</h3>
            <hr>
        </div>
    </div>

    <?php
    if (!empty($products)) {

        $pagingObj = new Paging($products, 12);
        $rows = $pagingObj->getRecords();
        $pagingObj->_url = Url::getCurrentUrl(array(Url::$_page, Paging::$_key)) . 'page=index';
    ?>

    <!-- products -->
    <div class="row">
    <?php foreach ($rows as $key => $product) { ?>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="thumbnail">

                <?php
                $image = (!empty($product['image'])) ?
                    Catalog::$_image_path . $product['image'] :
                    Catalog::$_image_path . 'unavailable.png';

                $width = Helper::getImageSize($image, 0);
                $width = ($width > 242) ? 242 : $width;
                ?>
                <a href="<?= "?page=catalog-item&category={$product['category']}&id={$product['id']}"; ?>">
                    <img src="<?=$image?>" class="img-thumbnail" width="<?=$width?>" alt="<?=$product['name'];?>">
                </a>
                <div class="caption">
                    <div class="desc">
                        <h4 class="small"><strong><?=htmlspecialchars($product['name']);?></strong></h4>
                        <p class="small text-justify"><?=htmlspecialchars(Helper::shortenString($product['description']));?></p>
                    </div>
                    <p class="text-center"><?=Catalog::$_currency.' '.number_format($product['price'], 2);?></p>
                    <p class="text-center"><?= Basket::buttonActive($product['id']); ?></p>
                </div>
            </div>
        </div>

    <?php } ?>

        <div class="clearfix"></div>

        <div class="col-xs-12">
            <?=$pagingObj->getPages();?>
        </div>

    </div>
    <!-- /products -->
    <?php } else { ?>
        <p>No Product available yet.</p>
<?php } ?>
</div>
<!-- /show case -->

<?php require_once('_footer.php'); ?>