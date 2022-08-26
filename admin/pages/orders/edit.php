<?php
$id = Url::getParam('id');
if (!empty($id)) {

    $orderObj = new Order();
    $order = $orderObj->getOrder($id);
    
    if (!empty($order)) {

        $formObj = new Form();
        $validatorObj = new Validation($formObj);

        $userObj = new User();
        $user = $userObj->getUserById($order['client']);

        $countryObj = new Country();

        $catalogObj = new Catalog();
        $items = $orderObj->getOrderItems($id);
        $statuses = $orderObj->getStatuses();

        if ($formObj->isPost('status')) {

            $validatorObj->_expected = array('status', 'payment_status', 'notes');
            $validatorObj->_required = array('status');

            $values = $formObj->getPostArray($validatorObj->_expected);

            if ($validatorObj->isValid()) {
                if ($orderObj->updateOrder($validatorObj->_post, $id)) {
                    Session::setSession('edited', 'Order has been updated successfully.');
                } else {
                    Session::setSession('edited', 'There was a problem updating this record. Please try again or contact administrator.');
                }
                Helper::redirect('/admin/?page=orders');
            }
        }

        require_once('templates/_header.php');
        ?>

        <!-- main contents -->
        <div class="col-md-9 col-sm-8 col-xs-12">

        <!-- heading and specific links -->
        <div class="row">
            <div class="col-sm-6 col-xs-10">
                <h3 class="media-heading">Orders :: Edit</h3>
            </div>

            <div class="col-sm-6 col-xs-2">
                <div class="btn-group btn-group-sm pull-right">
                    <?= Helper::getBackBtn(); ?>
                </div>
            </div>
        </div>
        <!-- /heading and specific links -->

        <hr>

        <div class="row">
            <div class="col-xs-12">
                
                <dl class="dl-horizontal">
                    <dt>Date :</dt>
                    <dd><?=Helper::setDate(2, $order['date']);?></dd>

                    <p>
                    <dt>Order # :</dt>
                    <dd><?=$order['id'];?></dd>
                    </p>

                    <dt>Items :</dt>
                    <dd>
                        <?php if (!empty($items)){ ?>
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($items as $item) { ?>
                                    <?php $product = $catalogObj->getProduct($item['product']) ?>
                                    <tr>
                                        <td><?=$product['id'];?></td>
                                        <td><?=htmlspecialchars($product['name']);?></td>
                                        <td><?=$item['qty'];?></td>
                                        <td>
                                            <?=Catalog::$_currency.' '.number_format($item['qty']*$product['price'], 2);?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <th colspan="3">Sub-Total :</th>
                                    <td><?=Catalog::$_currency.' '.number_format($order['subtotal'], 2);?></td>
                                </tr>

                                <tr>
                                    <th colspan="3">VAT (<?=$order['vat_rate'];?> %) :</th>
                                    <td><?=Catalog::$_currency.' '.number_format($order['vat'], 2);?></td>
                                </tr>

                                <tr>
                                    <th colspan="3">Total :</th>
                                    <td>
                                        <strong><?=Catalog::$_currency.' '.number_format($order['total'], 2);?></strong>
                                    </td>
                                </tr>
                            </tbody>
                            <?php } ?>
                        </table>
                    </dd>

                    <dt>Client's Info:</dt>


                    <dd>
<!--                        <div class="clearfix">&nbsp;</div>-->
                        <dl class="dl-horizontal well">
                            <dt>Name :</dt>
                            <dd><?=htmlspecialchars($user['first_name'].' '.$user['last_name']);?></dd>

                            <dt>Address 1 :</dt>
                            <dd><?=htmlspecialchars($user['address_1']);?></dd>

                            <dt>Address 2 :</dt>
                            <dd><?=htmlspecialchars($user['address_2']);?></dd>

                            <dt>City/Town :</dt>
                            <dd><?=htmlspecialchars($user['town']);?></dd>

                            <dt>State/Province :</dt>
                            <dd><?=htmlspecialchars($user['county']);?></dd>

                            <dt>Post Code :</dt>
                            <dd><?=htmlspecialchars($user['post_code']);?></dd>

                            <?php $country = $countryObj->getCountry($user['country']); ?>
                            <dt>Country :</dt>
                            <dd><?=htmlspecialchars($country['name']);?></dd>

                            <dt>Email :</dt>
                            <dd>
                                <a href="mailto:<?=htmlspecialchars($user['email']);?>"> <?=htmlspecialchars($user['email']);?></a>
                            </dd>

                        </dl>
                    </dd>
                    <?php if ($order['type'] == 0) { ?>
                        <dt>PayPal Status :</dt>
                        <dd><?=htmlspecialchars((!empty($order['payment_status']))? $order['payment_status']: 'Pending');?></dd>
                    <?php } ?>
                </dl>

                <form action="" method="post" class="form-horizontal">
                    <dl class="dl-horizontal">
                        <?php if ($order['type'] == 1) { ?>
                        <dt><label for="payment_status" class="control-label">Payment Status :</label></dt>

                        <dd>
                            <?=$validatorObj->validate('payment_status');?>
                            <select name="payment_status" id="payment_status" class="form-control">
                                <option value="Pending" <?=$formObj->stickySelect('status', 'Pending', $order['payment_status']);?>>
                                    Pending
                                </option>
                                <option value="Completed" <?=$formObj->stickySelect('status', 'Completed', $order['payment_status']);?>>
                                    Completed
                                </option>
                            </select>
                        </dd>
                        <?php } ?>
                        <p></p>
                        <dt><label for="status" class="control-label">Order Status :</label></dt>
                    
                        <dd>
                            <?=$validatorObj->validate('status');?>
                            <?php if (!empty($statuses)) { ?>
                                <select name="status" id="status" class="form-control">
                                    <?php foreach ($statuses as $status){ ?>
                                        <option value="<?=$status['id'];?>" <?=$formObj->stickySelect('status', $status['id'], $order['status']);?>>
                                            <?=htmlspecialchars($status['name']);?>
                                        </option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                        </dd>

                        <p></p>
                        <dt><label for="notes" class="control-label">Notes :</label></dt>
                        <dd>
                            <textarea name="notes" id="notes" rows="5" class="form-control"><?=$formObj->stickyText('notes', $order['notes']);?></textarea>
                        </dd>
                        <p></p>
                        <dt>&nbsp;</dt>
                        <dd>
                            <!-- <a href="<?='/admin'.Url::getCurrentUrl(array('action', 'id'));?>" class="btn btn-sm btn-primary">Go Back</a> -->
                            <input type="submit" id="btn_update" value="Update" class="btn btn-sm btn btn-primary">
                            <div class="pull-right">
                                <a href="<?='/admin'.Url::getCurrentUrl(array('action')).'&action=invoice';?>" class="btn btn-sm btn-primary" target="_blank">Invoice</a>
                            </div>
                        </dd>
                    </dl>

                </form>

            </div>
        </div>
        

    <?php require_once('templates/_footer.php');
    }
}

?>