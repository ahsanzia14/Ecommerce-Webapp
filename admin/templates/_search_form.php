<div class="row">
    <div class="col-sm-12">
        <form action="" method="get" class="form-horizontal form-condensed">
            <?php echo Url::getSearchParam(array('search', Paging::$_key)); ?>
            <!--            <div class="form-group control-group">-->
            <!--                <label for="search" class="col-sm-offset-1 col-sm-2 control-label">Search</label>-->
            <!--                <div class="col-sm-6">-->
            <!--                    <input type="text" name="search" id="search" class="form-control"-->
            <!--                           value="--><? //= stripslashes($search); ?><!--">-->
            <!--                </div>-->
            <!--                <br class="visible-xs">-->
            <!--                <div class="col-sm-2">-->
            <!--                    <input type="submit" class="btn btn-sm btn-primary" value="Search">-->
            <!--                </div>-->
            <!--            </div>-->

            <div class="col-sm-offset-2 col-sm-8 col-xs-12">
                <div class="input-group">
                    <label for="search" class="input-group-addon"><i>Search</i></label>
                    <input type="text" name="search" id="search" class="form-control"
                           value="<?= stripslashes($search); ?>">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search fa-fw"></i></button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>