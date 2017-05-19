<?php

namespace Plugin\KbWidgets\Widget\KbTable;

class Controller extends \Ip\WidgetController{

    public function defaultData(){
        return [
            'rows' => 2,
            'columns' => 2
        ];
    }
     
	public function getTitle(){
		return __('Tabela', 'Ip-admin', false);
	}

	public function update($widgetId, $postData, $currentData)
    {
        $postData['blocks'] = $this->prepareData($widgetId, $postData);
                
        return parent::update($widgetId, $postData, $currentData);
    }

	public function generateHtml($revisionId, $widgetId, $data, $skin)
    {
        $blocks = $this->prepareData($widgetId, $data);
        $data['blocks'] = $blocks;
        $data['revisionId'] = $revisionId;
        $data['tblid'] = $widgetId;

        return parent::generateHtml($revisionId, $widgetId, $data, $skin);;
    }

    private function prepareData($widgetId, $data){
        if (isset($data['blocks']) && is_array($data['blocks'])){
            return $data['blocks'];
        }
        $blocks = array();
        for ($i = 0; $i <= $data['rows']; $i++){
        	for ($j=0; $j < $data['columns']; $j++) { 
        		$blocks[$i][$j] = 'table-'.$widgetId.'_r_'.$i.'_c_'.$j;
        	}            
        }
        return $blocks;
    }
}