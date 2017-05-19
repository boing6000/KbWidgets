<?php
namespace Plugin\KbWidgets\Widget\KbSlideShow;


class Model {

    const TABLE_NAME = 'kb_slideshow';

    public static function widgetItems($widgetId, $visibleOnly = true)
    {
        $params = array(
            'widgetId' => $widgetId
        );
        if ($visibleOnly) {
            $params['isVisible'] = 1;
        }
        return ipDb()->selectAll(self::TABLE_NAME, '*', $params, ' ORDER BY `itemOrder` asc');
    }



    public static function addItem($data)
    {
        ipDb()->insert(self::TABLE_NAME, $data);
    }

    public static function removeWidgetItems($widgetId)
    {
        return ipDb()->delete(self::TABLE_NAME, array('widgetId' => $widgetId));
    }
	
	public static function showImage($value, $recordData = null)
    {

        if ($value) {
            $transform = array (
                'type' => 'fit',
                'width' => 100,
                'height' => 100
            );
            $thumbnailUrl = ipReflection($value, $transform, 'preview.jpg');

            $imageHtml = '<a href="' . ipFileUrl('file/repository/' . $value) . '" target="blank"><img src="' . $thumbnailUrl . '" alt="' . esc($value) . '"></a>';

            return $imageHtml;
        } else {
            return false;
        }
    }

}
