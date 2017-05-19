<?php
/**
 * Created by PhpStorm.
 * User: boing
 * Date: 16/05/2017
 * Time: 07:04
 */

namespace Plugin\KbWidgets\Model;


interface Model
{
    /**
     * @param $widgetId
     * @return array
     */
    public function widgetPopUpHtml($widgetId);

    /**
     * @return array|mixed
     */
    public function checkForm();

    /**
     * @param array $widgetData
     * @return \Ip\Form
     */
    function __managementForm($widgetData = []);
}