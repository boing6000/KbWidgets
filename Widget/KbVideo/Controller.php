<?php

namespace Plugin\KbWidgets\Widget\KbVideo;

class Controller extends \Ip\WidgetController{
	public function getTitle(){
		return __('Video', 'Ip-admin', false);
	}
}