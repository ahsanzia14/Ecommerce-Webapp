<?php
$catalogObj = new Catalog();
$categories = $catalogObj->getCategories();

$businessObj = new Business();
$business = $businessObj->getBusiness();

require_once('includes/_header.php');

if (empty($_SERVER['QUERY_STRING']))
    require_once('includes/_slideshow.php');
?>

<div class="clearfix">&nbsp;</div>

<!-- main container -->
<div class="container">
    <!-- main row -->
    <div class="row">

        <!-- cart and categories links -->
        <div class="col-md-3 col-sm-4 col-xs-12">
            <?php
            require_once('includes/_cart.php');
            require_once('includes/_categories.php');
            ?>
        </div>
        <!-- /cart and categories links -->