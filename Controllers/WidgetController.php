<?php
/**
 * Created by PhpStorm.
 * User: boing
 * Date: 16/05/2017
 * Time: 06:57
 */

namespace Plugin\KbWidgets\Controllers;


use Plugin\KbWidgets\Model\Button;
use Plugin\KbWidgets\Model\Maps;
use Plugin\KbWidgets\Model\Model;
use Plugin\KbWidgets\Model\Slideshow;
use Plugin\KbWidgets\Model\Table;
use Plugin\KbWidgets\Model\Video;

class WidgetController extends Controller
{
    private $widget;
    /**
     * @var $model Model
     */
    private $model;
    private $widgets = [
        'table' => Table::class,
        'video' => Video::class,
        'maps' => Maps::class,
        'slideshow' => Slideshow::class,
        'button' => Button::class
    ];

    public function __construct($widget = '')
    {
        $this->widget = $widget;
        parent::__construct();
    }

    public function widgetPopupHtml(){
        if($this->checkWidget()){
            $widgetId = ipRequest()->getQuery('id');

            return $this->json($this->model->widgetPopUpHtml($widgetId));
        }

        return $this->json('widget not found', true);
    }

    public function checkForm(){
        if($this->checkWidget()){
            return $this->json($this->model->checkForm());
        }

        return $this->json('widget not found', true);
    }

    private function checkWidget(){
        if (in_array($this->widget, array_keys($this->widgets))) {
            $this->model = new $this->widgets[$this->widget]();
            return true;
        }

        return false;
    }
}