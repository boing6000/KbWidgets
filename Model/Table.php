<?php
namespace Plugin\KbWidgets\Model;

/**
 * Created by PhpStorm.
 * User: boing
 * Date: 16/05/2017
 * Time: 07:03
 */
class Table implements Model
{

    public function widgetPopUpHtml($widgetId)
    {
        $widgetRecord = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
        $widgetData = $widgetRecord['data'];

        //create form prepopulated with current widget data
        $form = $this->__managementForm($widgetData);

        //Render form and popup HTML
        $viewData = array(
            'title' =>  __('Configurações da Tabela', 'KbWidgets', true),
            'id' => 'kbWidgetsTable',
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
                'value' => 'table'
            )
        );
        $form->addField($field);

        //Input fields to adjust widget settings

        $field = new \Ip\Form\Field\Select(
            array(
                'name' => 'classes',
                'label' => 'Class',
                'value' => empty($widgetData['classes']) ? 'table' : $widgetData['classes'],
                'values' => [
                    ['table', 'Padrão'],
                    ['table table-striped', 'Listrado'],
                    ['table table-bordered', 'Com bordas'],
                    ['table table-striped table-bordered', 'Com bordas & Listrado']
                ]
            )
        );
        $field->addValidator('Required');
        $form->addField($field);

        $field = new \Ip\Form\Field\Integer(
            array(
                'name' => 'columns',
                'label' => 'Colunas',
                'value' => empty($widgetData['columns']) ? 2 : $widgetData['columns']
            )
        );
        $form->addField($field);

        $field = new \Ip\Form\Field\Integer(
            array(
                'name' => 'rows',
                'label' => 'Linhas',
                'value' => empty($widgetData['rows']) ? 2 : $widgetData['rows']
            )
        );
        $form->addField($field);

        return $form;
    }
}