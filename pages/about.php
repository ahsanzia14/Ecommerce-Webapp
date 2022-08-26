<?php require_once('_header.php'); ?>

    <!-- show case -->
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <h3>About Us</h3>
                <hr>
            </div>
        </div>

        <!-- about us -->
        <div class="row">

            <div class="col-xs-12">
                <p class="text-justify"><?=nl2br(htmlspecialchars($business['about']));?></p>
            </div>

        </div>
        <!-- /about us -->

    </div>
    <!-- /show case -->

<?php require_once('_footer.php') ?>