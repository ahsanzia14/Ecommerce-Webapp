<?php
$basketObj = new Basket();
?>

<div class="clearfix">&nbsp;</div>

<div id="basket_left">
    <!-- cart panel -->
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="row">
                    <div class="col-xs-12">
                        <span class="fa fa-shopping-cart"></span> <strong>Your Cart</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-body">

            <div class="row">
                <div class="col-xs-7">
                    No. of Items:
                </div>
                <div class="col-xs-5 text-right bl_ti"><span><?=$basketObj->_num_of_items;?></span></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-7">
                    Sub-Total:
                </div>
                <div class="col-xs-5 text-right bl_st"><?=Catalog::$_currency;?><span><?=number_format($basketObj->_sub_total, 2);?></span></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-7">
                    VAT (<span><?=$basketObj->_vat_rate;?> </span>%)
                </div>
                <div class="col-xs-5 text-right bl_vat"><?=Catalog::$_currency;?><span><?=number_format($basketObj->_vat, 2);?></span></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-7">
                    Total
                </div>
                <div class="col-xs-5 text-right bl_total"><?=Catalog::$_currency;?><span><?=number_format($basketObj->_total, 2);?></span></div>
            </div>
        </div>

        <div class="panel-footer">
            <div class="row">
                <div class="text-center">
                    <div class="btn-group btn-group-sm">
                        <a href="/?page=basket" class="btn btn-info">
                            <i class="fa fa-th-list"> </i> View Cart
                        </a>
                        <a href="/?page=checkout" class="btn btn-success" title="checkout">
                            <i class="fa fa-check"> </i> Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart panel -->
</div>

<div class="clearfix">&nbsp;</div>