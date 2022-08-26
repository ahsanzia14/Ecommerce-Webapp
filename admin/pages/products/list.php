<?php
$catalogObj = new Catalog();
$search = Url::getParam('search');

if (!empty($search)){
    $products = $catalogObj->getAllProducts($search);
    $empty = 'No search result found.';
} else {
    $products = $catalogObj->getAllProducts();
    $empty = 'No product is added yet.';
}

if (!empty($products)){
    $pagingObj = new Paging($products, 10);
    $rows = $pagingObj->getRecords();
    $pagingObj->_url = '/admin' . $pagingObj->_url;
}

require_once('templates/_header.php');
?>

<!-- main contents -->
<div class="col-md-9 col-sm-8 col-xs-12">

    <!-- heading and specific links -->
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h3 class="media-heading">Products</h3>
        </div>

        <div class="col-sm-6 col-xs-12">
            <div class="btn-group btn-group-sm pull-right">
                <a href="/admin/?page=products&action=add" class="btn btn-sm btn-primary">Add New Product</a>
                <a href="/admin/?page=products&action=report" class="btn btn-sm btn-primary">Summary</a>
            </div>
        </div>
    </div>
    <!-- /heading and specific links -->

    <hr>

    <!-- search form -->
    <?php require_once('templates/_search_form.php'); ?>
    <!-- /search form -->

    <hr>

    <!-- main table -->
    <p class="red">
        <?=Session::getSession('removed');?>
        <?=Session::getSession('added');?>
        <?=Session::getSession('edited');?>
    </p>

    <?php
    Session::cleanSession('removed');
    Session::cleanSession('added');
    Session::cleanSession('edited');
    ?>

    <?php if (!empty($rows)) { ?>
    <div class="table-responsive">
        <table class="table table-striped table-condensed">

            <thead>
            <tr>
                <th>ID</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Edit</th>
                <th>Remove</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach($rows as $key => $product) { ?>
                <tr>
                    <td><?=$product['id'];?></td>
                    <td><?=htmlspecialchars($product['name']);?></td>
                    <td><?=htmlspecialchars($product['qty']);?></td>
                    <td><a href="/admin/?page=products&action=edit&id=<?= $product['id']; ?>">Edit</a></td>
                    <td><a href="/admin/?page=products&action=remove&id=<?= $product['id']; ?>">Remove</a></td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>
    <!-- /main table -->

    <!-- paging -->
    <?=$pagingObj->getPages();?>
    <!-- /paging -->

    <?php } else { ?>
        <p><?=$empty;?></p>
    <?php } ?>

</div>
<!-- /main contents -->

<?php require_once('templates/_footer.php'); ?>