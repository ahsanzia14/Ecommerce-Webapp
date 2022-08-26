<?php
$code = Url::getParam('code');
if (!empty($code)){
    $heading = '';
    $message = '';
    $userObj = new User();
    $user = $userObj->getUserByHash($code);

    if (!empty($user)){
        if ($user['active'] == 0){

            if ($userObj->activateUser($user['id'])){

                $heading .=  '<h3>Activation Successful.</h3>';
                $message .= '<p>Your account has now been activated. Now you can login and proceed with your order.</p>';
            } else {
                $heading .=  '<h3>Activation Unsuccessful.</h3>';
                $message .= '<p>There has been a problem activating your account.</p>';
            }

        } else {
            $heading .=  '<h3>Account Already Activated.</h3>';
            $message .= '<p>This account has already been activated.</p>';
        }

    } else {
        Helper::redirect('?page=error');
    }

    require_once('_header.php');
?>

    <!-- show case -->
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <h3><?=$heading;?></h3>
                <hr>
            </div>
        </div>

        <!-- about us -->
        <div class="row">

            <div class="col-xs-12">
                <p class="text-justify"><?=$message;?></p>
            </div>

        </div>
        <!-- /about us -->

    </div>
    <!-- /show case -->

<?php
    require_once('_footer.php');

} else {
    Helper::redirect('?page=error');
}