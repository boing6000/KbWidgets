<?php
/**
 * Created by PhpStorm.
 * User: boing
 * Date: 16/05/2017
 * Time: 09:28
 */

namespace Plugin\KbWidgets\Model;


class Slideshow implements Model
{

    /**
     * @param $widgetId
     * @return array
     */
    public function widgetPopUpHtml($widgetId)
    {
        $widgetRecord = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
        $widgetData = $widgetRecord['data'];

        //create form prepopulated with current widget data
        $form = $this->__managementForm($widgetData);

        //Render form and popup HTML
        $viewData = array(
            'gridUrl' => ipActionUrl(array('aa' => 'KbWidgets.gridSlideshow', 'widgetId' => $widgetId, 'disableAdminNavbar' => 1))
        );
        $popupHtml = ipView('../view/iframePopup.php', $viewData)->render();
        $data = array(
            'popup' => $popupHtml
        );

        return $data;
    }

    /**
     * @return array|mixed
     */
    public function checkForm()
    {
        // TODO: Implement checkForm() method.
    }

    public function grid()
    {
        $gridConfig = array(
            'title' => 'Slide Show',
            'table' => 'kb_slideshow',
            'deleteWarning' => 'Tem Certeza?',
            'sortField' => 'slideshowOrder',
            'createPosition' => 'top',
            'createFilter' => function($data) {
                $data['widgetId'] = $_SESSION['widgetId'];
                return $data;
            },
            'filter' => ' `widgetId` = ' . $_SESSION['widgetId'],
            'gatewayData' => ['widgetId' => $_SESSION['widgetId']],
            'pageSize' => 20,
            'fields' => array(
                array(
                    'label' => 'Título',
                    'field' => 'title',
                    'validators' => array('Required')
                ),
                array(
                    'label' => 'Texto',
                    'field' => 'text',
                    'type' => 'RichText'
                ),
                array(
                    'label' => 'Url',
                    'field' => 'url',
                ),
                array(
                    'type' => 'RepositoryFile',
                    'label' => 'Image',
                    'showInList' => true,
                    'field' => 'image',
                    'preview' => 'Plugin\KbWidgets\Widget\KbSlideShow\Model::showImage'
                ),
                array(
                    'type' => 'Checkbox',
                    'label' => 'Visible',
                    'field' => 'isVisible',
                    'checked' => 1,
                    'defaultValue' => 1
                ),

            )
        );
        return $gridConfig;
    }

    /**
     * @param array $widgetData
     * @return \Ip\Form
     */
    function __managementForm($widgetData = [])
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
                'value' => 'slideshow'
            )
        );
        $form->addField($field);

        //Input fields to adjust widget settings

        $field = new \Ip\Form\Field\Text(
            array(
                'name' => 'title',
                'label' => 'Title',
                'value' => empty($widgetData['title']) ? null : $widgetData['title']
            )
        );
        $field->addValidator('Required');
        $form->addField($field);

        $field = new \Ip\Form\Field\RichText(
            array(
                'name' => 'text',
                'label' => 'Text',
                'value' => empty($widgetData['text']) ? null : $widgetData['text']
            )
        );
        $form->addField($field);

        $field = new \Ip\Form\Field\Text(
            array(
                'name' => 'url',
                'label' => 'Url',
                'value' => empty($widgetData['url']) ? null : $widgetData['url']
            )
        );
        $form->addField($field);

        $field = new \Ip\Form\Field\RepositoryFile(
            array(
                'name' => 'image',
                'label' => 'Image',
                'value' => empty($widgetData['image']) ? null : $widgetData['image'],
            )
        );
        $form->addField($field);

        $field = new \Ip\Form\Field\Checkbox(
            array(
                'name' => 'isVisible',
                'label' => 'Visible',
                'checked' => 1,
                'defaultValue' => 1
            )
        );
        $form->addField($field);
        //ADD YOUR OWN FIELDS


        return $form;
    }
}