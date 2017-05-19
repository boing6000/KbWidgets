<?php
/**
 * Created by PhpStorm.
 * User: boing
 * Date: 06/02/2017
 * Time: 09:54
 */

namespace Plugin\KbWidgets\Widget\KbSlideShow;


class Helper extends \Plugin\KbCore\Helper
{

    public static function parseDefault($data){
        $slides = [];
        foreach ($data as $slide) {
            $s = array_merge([
                'title' => ['text' => '', 'animation' => 'fadeInLeft'],
                'description' => ['text' => '', 'animation' => 'fadeInLeft'],
                'position' => 'left',
                'links' => [],
                'image' => []
            ], $slide);

            if (empty($s['text']['animation'])) {
                //$s['text']['animation'] = 'zoomInRight';
            }
            if (empty($s['description']['animation'])) {
                $s['description']['animation'] = 'fadeInLeft';
            }

            $slides[] = $s;
        }
        return $slides;
    }

}