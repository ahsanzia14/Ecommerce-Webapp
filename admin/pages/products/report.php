<?php
$catalogObj = new Catalog();
$products = $catalogObj->getStock();

$pagingObj = new Paging($products, 15);
$rows = $pagingObj->getRecords();

require_once('templates/_header.php');
?>

<!-- main contents -->
<div class="col-md-9 col-sm-8 col-xs-12">

    <!-- heading and specific links -->
    <div class="row">
        <div class="col-sm-10 col-xs-10">
            <h3 class="media-heading">Products :: Summary</h3>
        </div>

        <div class="col-sm-2 col-xs-2">
            <div class="btn-group btn-group-sm pull-right">
                <?= Helper::getBackBtn(); ?>
            </div>
        </div>
    </div>
    <!-- /heading and specific links -->

    <hr>

    <?php if (!empty($rows)) { ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Quantity</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($rows as $product) { ?>
                            <tr>
                                <td><?= $product['id']; ?></td>
                                <td><?= htmlspecialchars($product['name']); ?></td>
                                <td><?= htmlspecialchars($product['qty']); ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php echo $pagingObj->getPages();
    } else { ?>
        <p>Stock is Full.</p>
    <?php } ?>
</div>
<?php require_once('templates/_footer.php'); ?>
