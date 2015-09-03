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
     * Inserta un valor en una cookie dada
     * @param  mixed $value       El valor a insertar
     * @param  string $cookie_name el nombre de la cookie
     */
    public static function pushInCookie($value, $cookie_name)
    {
        $checkedItemsCookie = Yii::app()->request->cookies[$cookie_name];

        if ($checkedItemsCookie) {
            $checkedItemsArray = explode(',', $checkedItemsCookie->value);
        } else {
            $checkedItemsArray = array();
        }

        array_push($checkedItemsArray, $value);

        Yii::app()->request->cookies[$cookie_name] = new CHttpCookie($cookie_name, implode(',', $checkedItemsArray), array('path' => '/'));

    }


    /**
     * Devuelve un modelo con los puntos de venta que aparecen en el dataprovider
     * unique
     * @param  CDataprovider $dataProvider
     * @return Purchase::model()
     */
    public static function getUniqueInDataprovider($dataProvider, $field, $order = 'created_at ASC')
    {
        $criteria = $dataProvider->getCriteria();
        $criteria->group = $field;
        $criteria->addCondition($field . ' <> 0');
        $criteria->order = $order;

        $dataProvider->setCriteria($criteria);

        return $dataProvider->data;
    }

    /**
     * Recibe el numero de contrato de la afip y lo formatea a:
     * 4 digitos de punto de venta - (guión) 8 digitos de numero de contrato
     *
     * @author Richard Grinberg <rggrinberg@gmail.com>
     * @param  integer $contract_number numero de contrato recibido de la afip
     * @return string                  Numero de contrato con el formato 000-00000000
     */
    public static function formatearNumeroDeContrato($punto_de_venta, $contract_number)
    {
        $contract_pdv_num = str_pad($punto_de_venta, 4, "0", STR_PAD_LEFT);
        $contract_cn_num = str_pad($contract_number, 8, "0", STR_PAD_LEFT);
        $final_contract_number = $contract_pdv_num . '-' . $contract_cn_num;

        return $final_contract_number;
    }
    
}
