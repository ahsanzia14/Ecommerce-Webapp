<?php
$search = Url::getParam('search');
$userObj = new User();
$orderObj = new Order();

if (!empty($search)) {
    $users = $userObj->getUsers($search);
    $empty = 'No search result found.';
} else {
    $users = $userObj->getUsers();
    $empty = 'No record is added yet.';
}

if (!empty($users)) {
    $pagingObj = new Paging($users, 10);
    $rows = $pagingObj->getRecords();
    $pagingObj->_url = '/admin' . $pagingObj->_url;
}

require_once('templates/_header.php'); ?>

<!-- main contents -->
<div class="col-md-9 col-sm-8 col-xs-12">

    <!-- heading and specific links -->
    <div class="row">
        <div class="col-sm-6 col-xs-10">
            <h3 class="media-heading">Clients</h3>
        </div>

        <div class="col-sm-6 col-xs-2">
            <div class="btn-group btn-group-sm pull-right">
                <a href="/admin/?page=clients&action=report" class="btn btn-sm btn-primary">Summary</a>
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
        <?= Session::getSession('removed'); ?>
        <?= Session::getSession('edited'); ?>
    </p>

    <?php
    Session::cleanSession('removed');
    Session::cleanSession('edited');
    ?>

    <?php if (!empty($rows)) { ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-striped table-condensed">

                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Edit</th>
                            <th>Remove</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($rows as $key => $user) { ?>
                            <tr>
                                <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                <td>
                                    <a href="/admin/?page=clients&action=edit&id=<?= $user['id']; ?>">Edit</a>
                                </td>
                                <td>
                                    <?php
                                    $orders = $orderObj->getClientOrders($user['id']);
                                    if (empty($orders)) { ?>
                                        <a href="/admin/?page=clients&action=remove&id=<?= $user['id']; ?>">Remove</a>
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
