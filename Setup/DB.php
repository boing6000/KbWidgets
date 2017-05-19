<?php
/**
 * Created by PhpStorm.
 * User: boing
 * Date: 16/02/2017
 * Time: 14:20
 */

namespace Plugin\KbWidgets\Setup;


use Plugin\KbCore\Eloquent;

class DB
{
    public static function install()
    {
        $sql = '
        CREATE TABLE IF NOT EXISTS
           ' . ipTable('kb_slideshow') . '
        (
        `id` int(11) NOT NULL AUTO_INCREMENT,
		`widgetId` int(11),
        `slideshowOrder` double,
        `title` varchar(255),
        `text` varchar(255),
        `url` varchar(255),
        `Enabled` boolean,
        `image` varchar(255),
		`lang` varchar(3),
		`itemOrder` double,
		`isVisible` int(1),
        PRIMARY KEY (`id`)
        )';

        ipDb()->execute($sql);

        $createModel = true;

    }
}