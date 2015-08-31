<?php
class PurchaseReferences extends CWidget
{
    public function init()
    {
        parent::init();
    }
 
    public function run()
    {
        if (get_class(Yii::app()->controller->purchase_references) != 'CActiveDataProvider') {
            return false;
        }
        
        $estados = $this->getStados();

        $this->render('application.views.widgets.references', array('menu_items' => $this->references($estados)));
    }

    /**
     * Genera y devuelve el array de items de menu con las referencias solo a los estados que existen acutalmente
     * entre los items de Purchase del DataProvider utilizado para armar la grilla
     * @param  array $estados array de modelos de Purchase
     * @return array          items del widget menu
     */
    public static function references($estados)
    {
        $references = array(
            array('label' => Yii::t('app', 'Referencias'), 'icon' => 'th-large', 'url' => '#', 'active' => true),
        );

        foreach ($estados as $key => $estado) {
            //die(var_dump(array_keys($estados)));
            array_push($references, array('label' => TbHtml::checkBox('status_search[' . $estado->constant_name . ']', Helper::checkedInCookie($estado->id, "checkedPurchaseStatuses"), array('value' => $estado->id, 'uncheckValue'=>'0', 'label' => Yii::t('app', $estado->name))), 'url' => '#', 'htmlOptions' => array('class' => 'pending ' . $estado->constant_name)));
        }

        return $references;
    }

    /**
     * Devuelve los estados de las purchases en el data provider
     * @author  RGG
     * @return array modelos Purchase
     */
    private function getStados()
    {
        $estados = array();

        $dataProvider = Yii::app()->controller->purchase_references;
        $criteria = $dataProvider->getCriteria();

        $criteria->group = 'current_status_id';

        $dataProvider->setCriteria($criteria);

        foreach ($dataProvider->data as $purchase) {
            $estados[$purchase->current_status_id] = '';
        }

        foreach ($estados as $key => $estado) {
            $estados[$key] = Status::model()->findByAttributes(array('id' => $key));
        }

        return $estados;
    }

}
