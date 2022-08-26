<?php
Login::restrictUser();

$orderObj = new Order();
$orders = $orderObj->getClientOrders(Session::getSession(Login::$_login_client));

$pagingObj = new Paging($orders, 5);
$rows = $pagingObj->getRecords();

require_once('_header.php');
?>

    <!-- show case -->
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <h3>Your Orders</h3>
                <hr>
            </div>
        </div>

        <!-- main content -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Invoice</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php if (!empty($rows)) { ?>
                            <?php foreach($rows as $key => $row) { ?>
                            <tr>
                                <td><?=$row['id'];?></td>
                                <td><?=Helper::setDate(1, $row['date']);?></td>
                                <td><?=($row['name']);?></td>
                                <td><?=Catalog::$_currency.' '.number_format($row['total'], 2);?></td>
                                <?php if ($row['payment_status'] == 'Completed' || $row['pp_status'] == 1) { ?>
                                    <td>
                                        <a href="?page=invoice&id=<?=$row['id'];?>" target="_blank" class="btn btn-xs btn-default">Invoice</a>
                                    </td>
                                <?php } else { ?>
                                    <td class="ta_r"><span class="btn btn-xs btn-default disabled">Invoice</span></td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-xs-12">
                <?=$pagingObj->getPages();?>
            </div>
        </div>
        <!-- /main content -->

    </div>
    <!-- /show case -->

<?php require_once('_footer.php'); ?>