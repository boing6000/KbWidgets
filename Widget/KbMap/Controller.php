<?php
/**
 * @package ImpressPages
 *
 */
namespace Plugin\KbWidgets\Widget\KbMap;


class Controller extends \Ip\WidgetController
{
    public function getTitle(){
        return 'Mapas';
    }

    public function generateHtml($revisionId, $widgetId, $data, $skin)
    {
        $data['options'] = $data;
        $data['mpId'] = uniqid('showMapDirectios');
        return parent::generateHtml($revisionId, $widgetId, $data, $skin);
    }
}
