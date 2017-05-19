<div id="<?php echo $id ?>" class="carousel bs-slider slide  control-round indicators-line" data-ride="carousel"
     data-pause="hover" data-interval="5000">

    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php foreach ($slides as $key => $slide): ?>
            <li data-target="#<?php echo $id ?>" data-slide-to="<?php echo $key ?>"
                class="<?php echo $key == 0 ? 'active' : '' ?>"></li>
        <?php endforeach; ?>
    </ol>

    <!-- Wrapper For Slides -->
    <div class="carousel-inner" role="listbox">

        <?php foreach ($slides as $key => $slide): ?>
            <!-- Slide <?php echo $key ?> -->
            <div class="item <?php echo $key == 0 ? 'active' : '' ?>">

                <!-- Slide Background -->
                <img src="<?php echo ipFileUrl(ipReflection($slide['image']['img'], $imageOptions['big'])) ?>"
                     alt="<?php echo $slide['image']['alt'] ?>" class="slide-image"/>
                <div class="bs-slider-overlay"></div>

                <div class="container">
                    <div class="row">
                        <!-- Slide Text Layer -->
                        <div class="slide-text slide_style_<?php echo !empty($slide['position']) ? $slide['position'] : 'left' ?>">
                            <h1 data-animation="animated <?php echo empty($slide['title']['animation']) ? 'fadeInLeft' : $slide['title']['animation'] ?>"><?php echo $slide['title']['text'] ?></h1>
                            <p data-animation="animated <?php echo $slide['description']['animation'] ?>"><?php echo $slide['description']['text'] ?>
                                .</p>
                            <?php foreach ($slide['links'] as $link) { ?>
                                <a href="<?php echo !empty($link['link']) ? $link['link'] : '#' ?>"
                                   target="<?php echo !empty($link['target']) ? $link['target'] : '_self' ?>"
                                   class="<?php echo !empty($link['class']) ? $link['class'] : 'btn btn-default' ?>"
                                   data-animation="animated <?php echo !empty($link['animation']) ? $link['animation'] : 'fadeInLeft' ?>">
                                    <?php echo !empty($link['title']) ? $link['title'] : 'Leia +' ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Slide <?php echo $key ?>-->
        <?php endforeach; ?>

    </div><!-- End of Wrapper For Slides -->

    <!-- Left Control -->
    <a class="left carousel-control" href="#<?php echo $id ?>" role="button" data-slide="prev">
        <span class="fa fa-angle-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>

    <!-- Right Control -->
    <a class="right carousel-control" href="#<?php echo $id ?>" role="button" data-slide="next">
        <span class="fa fa-angle-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>

</div>
<!-- End  <?php echo $id ?> Slider -->


<?php if (ipIsManagementState()): ?>
    <script>
        setTimeout(function () {
            $(window).trigger('ipWidgetSlideShow');
        }, 300)
    </script>
<?php endif; ?>
