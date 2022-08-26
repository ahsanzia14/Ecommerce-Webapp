<?php
$ordersObj = new Order();
$search = Url::getParam('search');

if (!empty($search)) {
    $orders = $ordersObj->getOrders($search);
    $empty = 'No search result found.';
} else {
    $orders = $ordersObj->getOrders();
    $empty = 'No product is added yet.';
}

if (!empty($orders)) {
    $pagingObj = new Paging($orders, 10);
    $rows = $pagingObj->getRecords();
    $pagingObj->_url = '/admin' . $pagingObj->_url;
}

require_once('templates/_header.php'); ?>

<!-- main contents -->
<div class="col-md-9 col-sm-8 col-xs-12">

    <!-- heading and specific links -->
    <div class="row">
        <div class="col-sm-6 col-xs-10">
            <h3 class="media-heading">Orders</h3>
        </div>

        <div class="col-sm-6 col-xs-2">
            <div class="btn-group btn-group-sm pull-right">
                <a href="/admin/?page=orders&action=report" class="btn btn-sm btn-primary">Summary</a>
            </div>
        </div>
    </div>
    <!-- /heading and specific links -->

    <hr>

    <!-- search form -->
    <?php require_once('templates/_search_form.php'); ?>
    <!-- /search form -->

    <hr>

    <!-- messages -->
    <p class="red">
        <?= Session::getSession('removed'); ?>
        <?= Session::getSession('edited'); ?>
    </p>

    <?php
    Session::cleanSession('removed');
    Session::cleanSession('edited');
    ?>
    <!-- /messages -->

    <?php if (!empty($rows)) { ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Via</th>
                            <th>Edit</th>
                            <th>Remove</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($rows as $key => $order) { ?>
                            <tr>
                                <td><?= $order['id']; ?></td>
                                <td><?= Helper::setDate(1, $order['date']); ?></td>
                                <td><?= Catalog::$_currency . ' ' . number_format($order['total'], 2); ?></td>
                                <td><?= $order['name']; ?></td>
                                <td><?= ($order['payment_status'] != null) ? $order['payment_status'] : 'Pending'; ?></td>
                                <td><?= ($order['type'] == 1) ? 'Bank' : 'PayPal'; ?></td>
                                <td><a href="/admin/?page=orders&action=edit&id=<?= $order['id']; ?>">View</a></td>

                                <td>
                                    <?php if ($order['status'] == 1) { ?>
                                        <a href="/admin/?page=orders&action=remove&id=<?= $order['id']; ?>">Remove</a>
                                    <?php } else { ?>
                                        <span class="inactive">Remove</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <?= $pagingObj->getPages(); ?>
    <?php } else { ?>
        <p><?= $empty; ?></p>
    <?php } ?>
</div>
<?php require_once('templates/_footer.php'); ?>
