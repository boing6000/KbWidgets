<?php

namespace Plugin\KbWidgets;

class Filter {
    public static function ipWidgetManagementMenu($optionsMenu,$widgetRecord)
    {
        switch ($widgetRecord['name']){
            case 'KbMap':
                $optionsMenu[] = array(
                    'title' => __( 'Configurações', 'KbMap', false ),
                    'attributes' => array(
                        'href' => '#ipWidget-' . $widgetRecord['id'],
                        'class' => '_edit ipsWidgetEdit',
                    )
                );
                break;
            case 'KbTable':
                $optionsMenu[] = array(
                    'title' => __( 'Configurações', 'KbTable', false ),
                    'attributes' => array(
                        'href' => '#ipWidget-' . $widgetRecord['id'],
                        'class' => '_edit ipsWidgetEdit',
                    )
                );
                break;
            default:
                break;
        }

        return $optionsMenu;
    }
}