<?php
class DispatchnoteReferences extends CWidget
{
    public $status;

    public function init()
    {
        parent::init();

        /**
         * Aca deben estar reflejados todas las constantes de estados del modelo DispatchNote
         * El nombre de la clase debe ser siempre el nombre de la constante en el modelo
         * @var array
         */
        $this->status = array(
            20 => array('name' => Yii::t('app', 'Pendiente de envío'), 'class_name' => 'PENDING_TO_SEND'),
            30 => array('name' => Yii::t('app', 'Enviada'), 'class_name' => 'SENT'),
            40 => array('name' => Yii::t('app', 'Cancelada'), 'class_name' => 'CANCELLED'),
            50 => array('name' => Yii::t('app', 'Parcialmente recibida'), 'class_name' => 'PARTIALLY_RECEIVED'),
            60 => array('name' => Yii::t('app', 'Recibida'), 'class_name' => 'RECEIVED'),
        );
    }
 
    public function run()
    {
        if (get_class(Yii::app()->controller->dispatchnote_references) != 'CActiveDataProvider') {
            return false;
        }
        
        $estados = Helper::getUniqueInDataprovider(Yii::app()->controller->dispatchnote_references, 'status');

        $this->render('application.views.widgets.references', array('menu_items' => $this->references($estados)));
    }

    /**
     * Genera y devuelve el array de items de menu con las referencias solo a los estados que existen acutalmente
     * entre los items de Purchase del DataProvider utilizado para armar la grilla
     * @param  array $estados array de modelos de Purchase
     * @return array          items del widget menu
     */
    public function references($estados)
    {
        $references = array(
        array('label' => Yii::t('app', 'Referencias'), 'icon' => 'th-large', 'url' => '#', 'active' => true),
        );

        foreach ($estados as $estado) {
            array_push($references, array('label' => TbHtml::checkBox('dispatchnote_search[' . $estado->status . ']', Helper::checkedInCookie($estado->status, "checkedDispatchnoteStatuses"), array('value' => $estado->status, 'uncheckValue'=>'0', 'label' => Yii::t('app', $this->status[$estado->status]['name']))), 'url' => '#', 'htmlOptions' => array('class' => $this->status[$estado->status]['class_name'])));
        }

        return $references;
    }

}
