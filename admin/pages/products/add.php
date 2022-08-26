<?php
$formObj = new Form();
$validatorObj = new Validation($formObj);

$catalogObj = new Catalog();
$categories = $catalogObj->getCategories();

if ($formObj->isPost('category')){

    $validatorObj->_expected = array(
        'category',
        'name',
        'description',
        'price',
        'image',
        'qty'
    );

    $validatorObj->_required = array(
        'category',
        'name',
        'description',
        'price'
    );
    
    if ($validatorObj->isValid()){
        if ($catalogObj->addProduct($validatorObj->_post)){
            $uploadObj = new Upload();
            if($uploadObj->upload(CATALOG_DIR)){
                $catalogObj->updateProduct(array('image' => $uploadObj->_names[0]), $catalogObj->_id);
                Session::setSession('added', 'Product has been added successfully.');
            } else {
                Session::setSession('added', 'Product has been added successfully without the image.');
            }
        } else {
            Session::setSession('added', 'There was a problem inserting this record. Please try again or contact administrator.');
        }
        Helper::redirect('/admin/?page=products');
    }
}

require_once('templates/_header.php');
?>

<!-- main contents -->
<div class="col-md-9 col-sm-8 col-xs-12">

    <!-- heading and specific links -->
    <div class="row">
        <div class="col-sm-8 col-xs-10">
            <h3 class="media-heading">Products :: Add</h3>
        </div>

        <div class="col-sm-4 col-xs-2">
            <div class="btn-group btn-group-sm pull-right">
                <?=Helper::getBackBtn();?>
            </div>
        </div>
    </div>
    <!-- /heading and specific links -->

    <hr>

    <!-- form -->
    <div class="row">
        <div class="col-lg-offset-1 col-lg-8 col-md-10 col-sm-12">
            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-condensed">

                <div class="form-group control-group">
                    <label for="category" class="col-sm-4 control-label">Category *</label>
                    <div class="col-sm-8">
                        <?=$validatorObj->validate('category');?>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select Category...</option>
                            <?php if(!empty($categories)) { ?>
                                <?php foreach($categories as $key => $category) { ?>
                                    <option value="<?=$category['id'];?>" <?=$formObj->stickySelect('category', $category['id']);?>>
                                        <?=htmlspecialchars($category['name']);?>
                                    </option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="name" class="col-sm-4 control-label">Name *</label>
                    <div class="col-sm-8">
                        <?=$validatorObj->validate('name');?>
                        <input type="text" id="name" name="name" class="form-control" value="<?=$formObj->stickyText('name');?>" />
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="description" class="col-sm-4 control-label">Description *</label>
                    <div class="col-sm-8">
                        <?=$validatorObj->validate('description');?>
                        <textarea name="description" id="description" class="form-control" cols="" rows="5"><?=$formObj->stickyText('description');?></textarea>
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="price" class="col-sm-4 control-label">Price (<?=Catalog::$_currency;?>) *</label>
                    <div class="col-sm-8">
                        <?=$validatorObj->validate('price');?>
                        <input type="text" min="0" name="price" id="price" class="form-control" value="<?=$formObj->stickyText('price');?>" />
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="qty" class="col-sm-4 control-label">Quantity </label>
                    <div class="col-sm-8">
                        <?=$validatorObj->validate('qty');?>
                        <input type="number" min="0" name="qty" id="qty" class="form-control" value="<?=$formObj->stickyText('qty');?>" />
                    </div>
                </div>

                <div class="form-group control-group">
                    <label for="image" class="col-sm-4 control-label">Image</label>
                    <div class="col-sm-8">
                        <?=$validatorObj->validate('image');?>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                </div>

                <div class="form-group control-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <input type="submit" id="btn" class="btn btn-sm btn-primary" value="Add">
                    </div>
                </div>

            </form>
        </div>
    </div>
    <!-- /form -->

</div>
<!-- /main contents -->

<?php require_once('templates/_footer.php'); ?>

