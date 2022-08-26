<?php
$catalogObj = new Catalog();
$search = Url::getParam('search');

if (!empty($search)) {
    $categories = $catalogObj->getAllCategory($search);
    $empty = 'No search result found.';
} else {
    $categories = $catalogObj->getCategories();
    $empty = 'No category is added yet.';
}

if (!empty($categories)) {
    $pagingObj = new Paging($categories, 10);
    $rows = $pagingObj->getRecords();
    $pagingObj->_url = '/admin' . $pagingObj->_url;
}

require_once('templates/_header.php'); ?>

<!-- main contents -->
<div class="col-md-9 col-sm-8 col-xs-12">

    <!-- heading and specific links -->
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h3 class="media-heading">Categories</h3>
        </div>

        <div class="col-sm-6 col-xs-12">
            <div class="btn-group btn-group-sm pull-right">
                <a href="/admin/?page=categories&action=add" class="btn btn-sm btn-primary">Add New Category</a>
                <a href="/admin/?page=categories&action=report" class="btn btn-sm btn-primary">Summary</a>
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
        <?= Session::getSession('added'); ?>
        <?= Session::getSession('edited'); ?>
    </p>
    <!-- /messages -->

    <?php
    Session::cleanSession('removed');
    Session::cleanSession('added');
    Session::cleanSession('edited');
    ?>

    <?php if (!empty($rows)) { ?>
        <!-- main table -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">

                    <table class="table table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Remove</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($rows as $key => $category) { ?>
                            <tr>
                                <td><?= $category['id']; ?></td>
                                <td><?= htmlspecialchars($category['name']); ?></td>
                                <td><a href="/admin/?page=categories&action=edit&id=<?= $category['id']; ?>">Edit</a>
                                </td>
                                <td>
                                    <a href="/admin/?page=categories&action=remove&id=<?= $category['id']; ?>">Remove</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <!-- /main table -->
        <?= $pagingObj->getPages(); ?>
    <?php } else { ?>
        <p><?= $empty; ?></p>
    <?php } ?>
</div>
<?php require_once('templates/_footer.php'); ?>
