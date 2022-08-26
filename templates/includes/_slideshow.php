<!-- container for slide show -->
<div class="container-fluid">
    <div class="row">
        <div class="hidden-xs">

            <!-- carousel -->
            <div id="my-slider" class="carousel slide" data-ride="carousel">

                <!-- carousel indicators -->
                <ol class="carousel-indicators">
                    <?php for ($i = 0; $i < 4; $i++) { ?>
                        <li data-target="#my-slider" data-slide-to="<?= $i; ?>"
                            class="<?= ($i == 0) ? 'active' : ''; ?>"></li>
                    <?php } ?>
                </ol>

                <!-- carousel slides -->
                <div class="carousel-inner" role="listbox">
                    <?php for ($c = 0; $c < 4; $c++) { ?>
                        <div class="item <?= ($c == 0) ? 'active' : ''; ?>">
                            <img width="100%" src="/media/example-slide-00<?= $c; ?>.jpg" alt="">
                            <div class="carousel-caption">
<!--                                <h1>--><?//= 'Slide # ' . ($c + 1); ?><!--</h1>-->
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- carousel controllers -->
                <a class="left carousel-control" href="#my-slider" data-slide="prev" role="button">
                    <span class="icon-prev" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#my-slider" data-slide="next" role="button">
                    <span class="icon-next" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>

            </div>
            <!-- /carousel -->
        </div>
    </div>
</div>
<!-- /container for slide show -->