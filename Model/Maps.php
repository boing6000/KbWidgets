<?php
namespace Plugin\KbWidgets\Model;

/**
 * Created by PhpStorm.
 * User: boing
 * Date: 16/05/2017
 * Time: 07:03
 */
class Maps implements Model
{

    public function widgetPopUpHtml($widgetId)
    {
        $widgetRecord = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
        $widgetData = $widgetRecord['data'];

        //create form prepopulated with current widget data
        $form = $this->__managementForm($widgetData);

        //Render form and popup HTML
        $viewData = array(
            'title' =>  __('Configurações do Maps', 'KbWidgets', true),
            'id' => 'kbWidgetsMap',
            'form' => $form
        );
        $popupHtml = ipView('../view/editPopup.php', $viewData)->render();
        $data = array(
            'popup' => $popupHtml
        );

        return $data;
    }

    public function checkForm()
    {
        $data = ipRequest()->getPost();
        $form = $this->__managementForm();
        $data = $form->filterValues($data); //filter post data to remove any non form specific items
        $errors = $form->validate($data); //http://www.impresspages.org/docs/form-validation-in-php-3
        if ($errors) {
            //error
            $data = array (
                'status' => 'error',
                'errors' => $errors
            );
        } else {
            //success
            unset($data['aa']);
            unset($data['securityToken']);
            unset($data['antispam']);
            $data = array (
                'status' => 'ok',
                'data' => $data

            );
        }
        return $data;
    }

    public function __managementForm($widgetData = [])
    {
        $form = new \Ip\Form();

        $form->setEnvironment(\Ip\Form::ENVIRONMENT_ADMIN);

        //setting hidden input field so that this form would be submitted to 'errorCheck' method of this controller. (http://www.impresspages.org/docs/controller)
        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'aa',
                'value' => 'KbWidgets.widget'
            )
        );
        $form->addField($field);

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'action',
                'value' => 'checkForm'
            )
        );
        $form->addField($field);

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'widget',
                'value' => 'maps'
            )
        );
        $form->addField($field);

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'lat',
                'value' => empty($widgetData['lat']) ? '0' : $widgetData['lat']
            )
        );
        $form->addField($field);

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'lng',
                'value' => empty($widgetData['lng']) ? '0' : $widgetData['lng']
            )
        );
        $form->addField($field);

        //Input fields to adjust widget settings

        $field = new \Ip\Form\Field\Text(
            array(
                'name' => 'address',
                'label' => __('Endereço', 'KbWidgets', false),
                'value' => empty($widgetData['address']) ? '' : $widgetData['address']
            )
        );
        $form->addField($field);

        $field = new \Ip\Form\Field\Text(
            array(
                'name' => 'height',
                'label' => __('Tamanho do Mapa', 'KbWidgets', false),
                'value' => empty($widgetData['height']) ? '300px' : $widgetData['height']
            )
        );
        $form->addField($field);

        $field = new \Ip\Form\Field\Number(
            array(
                'name' => 'zoom',
                'label' => __('Zoom', 'KbWidgets', false),
                'value' => empty($widgetData['zoom']) ? 16 : $widgetData['zoom']
            )
        );
        $form->addField($field);

        $field = new \Ip\Form\Field\Checkbox(
            array(
                'name' => 'scrollWheel',
                'label' => __('Scroll Wheel', 'KbWidgets', false),
                'value' => empty($widgetData['scrollWheel']) ? false : $widgetData['scrollWheel']
            )
        );
        $form->addField($field);

        $field = new \Ip\Form\Field\Checkbox(
            array(
                'name' => 'zoomControl',
                'label' => __('Exibir Zoom', 'KbWidgets', false),
                'value' => empty($widgetData['zoomControl']) ? true : $widgetData['zoomControl']
            )
        );
        $form->addField($field);

        $field = new \Ip\Form\Field\Checkbox(
            array(
                'name' => 'directions',
                'label' => __('Exibibir Direções', 'KbWidgets', false),
                'value' => empty($widgetData['directions']) ? true : $widgetData['directions']
            )
        );
        $form->addField($field);

        $values = array(
            array('ROADMAP', 'Roadmap'),
            array('SATELLITE', 'Satellite'),
            array('HYBRID', 'Hybrid'),
            array('TERRAIN', 'Terrain')
        );
        $field = new \Ip\Form\Field\Select(
            array(
                'name' => 'mapType',
                'label' => __('Tipo de Mapa', 'KbWidgets', false),
                'values' => $values,
                'value' => empty($widgetData['mapType']) ? 'HYBRID' : $widgetData['mapType']
            )
        );
        $form->addField($field);

        return $form;
    }
}