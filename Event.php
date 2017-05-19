<?php
/**
 * Created by PhpStorm.
 * User: boing
 * Date: 11/01/2017
 * Time: 16:22
 */

namespace Plugin\KbWidgets;


class Event
{
    public static function ipBeforeController()
    {
        if(ipIsManagementState()){
            //slideshow
            ipAddCss('Plugin/KbWidgets/assets/KbSlideshow/css/gridWidget.css');
        }
        //video
        ipAddCss('Plugin/KbWidgets/assets/KbVideo/plyr.css');
        ipAddJs('Plugin/KbWidgets/assets/KbVideo/plyr.js');
        ipAddJs('Plugin/KbWidgets/assets/KbVideo/KbVideo.js');

        //slideshow
        ipAddCss('Plugin/KbWidgets/assets/KbSlideshow/css/bootstrap-touch-slider.css');
        ipAddJs('Plugin/KbWidgets/assets/KbSlideshow/js/jquery.touchSwipe.js');
        ipAddJs('Plugin/KbWidgets/assets/KbSlideshow/js/bootstrap-touch-slider.js');
        ipAddJs('Plugin/KbWidgets/assets/KbSlideshow/js/KbSlideshow.js');

        //maps
        ipAddCss('Plugin/KbWidgets/assets/KbMaps/KbMaps.css');
        ipAddJs('Plugin/KbWidgets/assets/KbMaps/GMAP3.js');
        ipAddJs('Plugin/KbWidgets/assets/KbMaps/KbMaps.js');
    }

}