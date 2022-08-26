<?php
$userObj = new User();
$report = $userObj->getClientsReport();

$pagingObj = new Paging($report, 10);
$rows = $pagingObj->getRecords();

require_once('templates/_header.php');
?>
<!-- main contents -->
<div class="col-md-9 col-sm-8 col-xs-12">

    <!-- heading and specific links -->
    <div class="row">
        <div class="col-sm-10 col-xs-10">
            <h3 class="media-heading">Clients :: Summary</h3>
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
                            <th>Name</th>
                            <th>No. of Orders</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($rows as $user) { ?>
                            <tr>
                                <td><?= $user['id']; ?></td>
                                <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                <td><?= $user['total']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <?php echo $pagingObj->getPages();

    } else { ?>
        <p>No Client is added yet.</p>
    <?php } ?>
</div>
<?php require_once('templates/_footer.php'); ?>
