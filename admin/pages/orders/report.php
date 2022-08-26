<?php
$orderObj = new Order();
$report = $orderObj->getReport();

$total = array_pop($report);

require_once('templates/_header.php');
?>

<!-- main contents -->
<div class="col-md-9 col-sm-8 col-xs-12">

    <!-- heading and specific links -->
    <div class="row">
        <div class="col-sm-10 col-xs-10">
            <h3 class="media-heading">Orders :: Summary</h3>
        </div>

        <div class="col-sm-2 col-xs-2">
            <div class="btn-group btn-group-sm pull-right">
                <?= Helper::getBackBtn(); ?>
            </div>
        </div>
    </div>
    <!-- /heading and specific links -->

    <hr>

    <?php if (!empty($report)) { ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>Order Status</th>
                            <th>No. of Orders</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($report as $row) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td><?= $row['total']; ?></td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td><Strong>Total</Strong></td>
                            <td><strong><?= $total; ?></strong></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php } else { ?>
        <p>No Order is added yet.</p>
    <?php } ?>
</div>
<?php
require_once('templates/_footer.php');
?>
