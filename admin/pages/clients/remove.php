<?php
$id = Url::getParam('id');
if (!empty($id)) {

    $userObj = new User();
    $user = $userObj->getUserById($id);

    if (!empty($user)) {

        $orderObj = new Order();
        $orders = $orderObj->getClientOrders($id);
        if (!empty($orders)){
            Session::setSession('removed', 'Client has pending order(s) yet.');
            Helper::redirect('/admin/?page=clients');
        }

        if (Url::getParam('remove') == 1){
            if($userObj->removeUser($id)){
                Session::setSession('removed', 'The client has been removed successfully.');
            } else {
                Session::setSession('removed', 'There was a problem removing this record. Please try again or contact administrator.');
            }
            Helper::redirect('/admin/?page=clients');
        }

        require_once('templates/_header.php');
        ?>

        <!-- main contents -->
        <div class="col-md-9 col-sm-8 col-xs-12">

            <!-- heading and specific links -->
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <h3 class="media-heading">Clients :: Remove</h3>
                </div>

                <div class="col-sm-6 col-xs-12">
                    <div class="btn-group btn-group-sm pull-right">
                        <?= Helper::getBackBtn(); ?>
                    </div>
                </div>
            </div>
            <!-- /heading and specific links -->

            <hr>

            <!--  -->
            <div class="row">
                <div class="col-xs-12">
                    <p>Are you sure to remove this record. There is no undo of this action.</p>
                    <p>
                        <a href="<?= Url::getCurrentUrl() . '&remove=1'; ?>">Yes</a> |
                        <a href="javascript:window.history.back()">No</a>
                    </p>
                </div>
            </div>
            <!-- / -->

        </div>
        <!-- /main contents -->

        <?php
    }
}
require_once('templates/_footer.php');
?>
