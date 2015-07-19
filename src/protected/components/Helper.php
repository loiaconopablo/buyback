<?php
class Helper
{
    public static function list_authitems()
    {
        return CHtml::listData(Authitem::model()->findAll(array('order'=>'name ASC')), 'name', 'name');
    }
    public static function list_authitems_by_type($type)
    {
        $condition='type='.$type;
        return CHtml::listData(Authitem::model()->findAll(array('condition'=>$condition,'order'=>'name ASC')), 'name', 'name');
    }
    public static function list_users()
    {
        return CHtml::listData(User::model()->findAll(array('order'=>'username ASC')), 'id', 'username');
    }
    public static function getStringTypeAuthitem($authitem_type)
    {
        switch ($authitem_type) {
            case Authitem::OPERATION:
                return 'Operation';
            case Authitem::TASK:
                return 'Task';
            case Authitem::ROLE:
                return 'Role';
            default:
                return 'NONE';
        }
    }

    public static function getDateFilterParams($prefix)
    {
        if (isset(Yii::app()->request->cookies[$prefix . 'from']->value)) {
            $date_from = DateTime::createFromFormat('d/m/Y', Yii::app()->request->cookies[$prefix . 'from']->value);
            $from = $date_from->format('Y-m-d');
        } else {
            $from = '000-00-00';
        }

        if (isset(Yii::app()->request->cookies[$prefix . 'to']->value)) {
            $date_to = DateTime::createFromFormat('d/m/Y H:i:s', Yii::app()->request->cookies[$prefix . 'to']->value . '24:59:59');
            $to = $date_to->format('Y-m-d H:i:s');
        } else {
            $to = '9999-12-31';
        }


        return array(
            ':from' => $from,
            ':to' => $to,
        );
    }

    /**
     * Chequea si el item esta en la cookie que mantiene los ids seleccionados
     * @param  integer $id Id del tipo de registro que se este seleccionando en la Grid
     * @return boolean     Devuelve si dicho item esta selecionado o no
     */
    public static function checkedInCookie($id, $cookie_name)
    {
        $checkedItemsCookie = Yii::app()->request->cookies[$cookie_name];

        if ($checkedItemsCookie) {
            $checkedItemsArray = explode(',', $checkedItemsCookie->value);

            return in_array($id, $checkedItemsArray);
        }
        
        return false;
    }


    /**
     * Devuelve un modelo con los puntos de venta que aparecen en el dataprovider
     * unique
     * @param  CDataprovider $dataProvider
     * @return Purchase::model()
     */
    public static function getUniqueInDataprovider($dataProvider, $field)
    {
        $criteria = $dataProvider->getCriteria();
        $criteria->group = $field;

        $dataProvider->setCriteria($criteria);

        return $dataProvider->data;
    }
    
}
