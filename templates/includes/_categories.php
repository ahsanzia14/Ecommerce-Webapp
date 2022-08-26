<!-- categories -->
<div class="hidden-xs">
    <h4>Categories</h4>
    <ul class="nav nav-pills nav-stacked">
        <?php foreach ($categories as $key => $cat) { ?>
            <li class="<?=Helper::getActive(array('category' => $cat['id']));?>" role="presentation">
                <a href="<?='/?page=catalog&category='.$cat['id'];?>"><?=$cat['name'];?></a>
            </li>
        <?php } ?>
    </ul>
</div>
<!-- /categories -->