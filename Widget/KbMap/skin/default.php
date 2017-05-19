<?php if(!empty($options['directions']) && $options['directions']):?>
    <div class="floating-directions-panel hide" id="<?php echo $mpId ?>Directions">
        <a class="btn btn-link" role="button" data-toggle="collapse"
           href="#<?php echo $mpId ?>Toggle" aria-expanded="false" aria-controls="collapseExample">Mostrar Rota</a>
        <div id="<?php echo $mpId ?>Toggle" class="collapse">
            <div class="col-md-12">
                <div class="input-group">
                    <input type="text" class="form-control ipsWidgetMapLocationSearch" id="<?php echo $mpId ?>Start" placeholder="Origem">
                    <div class="input-group-btn">
                        <button type="button" id="<?php echo $mpId ?>Btn" class="btn btn-default btn-find-directions">
                            Mostrar Rota
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 ride-actions" style="display:none; margin-top: 5px;">
                <div class="btn-group ">
                    <button type="button" class="btn btn-default btn-bike"><i class="fa fa-bicycle"></i> </button>
                    <button type="button" class="btn btn-default btn-car active"><i class="fa fa-car"></i> </button>
                    <button type="button" class="btn btn-default btn-walk"><i class="fa fa-male"></i> </button>
                </div>
                <button type="button" class="btn btn-default btn-print"><i class="fa fa-print"></i> </button>
            </div>
            <div class="col-md-12 directions" style="height: calc(<?php echo $height;?> - 190px); display: none;" id="<?php echo $mpId ?>Panel"></div>
        </div>
    </div>
<?php endif;?>

<div    style="height: <?php echo($height); ?>; width: 100%;"
        data-initialized="0" id="<?php echo $mpId?>"
    <?php
    foreach ($options as $option => $value) {
        echo 'data-' . strtolower($option) . '="' . $value . '" ';
    }
    ?>
        class="ipsMap">
</div>


