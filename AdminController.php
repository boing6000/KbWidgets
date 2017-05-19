<?php
/**
 * Created by PhpStorm.
 * User: boing
 * Date: 16/05/2017
 * Time: 06:55
 */

namespace Plugin\KbWidgets;


use Plugin\KbWidgets\Controllers\WidgetController;
use Plugin\KbWidgets\Model\Slideshow;

class AdminController
{
    public function widget()
    {
        if (ipRequest()->getPost('widget')) {
            $widget = ipRequest()->getPost('widget');
        } else {
            $widget = ipRequest()->getQuery('widget');
        }
        $controller = new WidgetController($widget);
        return $controller->render();
    }

    public function gridSlideshow()
    {
        $model = new Slideshow();

        if (!empty(ipRequest()->getQuery('widgetId'))) {
            $widgetId = ipRequest()->getQuery('widgetId');
            $_SESSION['widgetId'] = $widgetId;
        } else if (empty($_SESSION['widgetId'])) {
            return '';
        }

        $config = $model->grid();

        return ipGridController($model->grid());
    }
}