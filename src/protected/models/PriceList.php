<?php

Yii::import('application.models._base.BasePriceList');

class PriceList extends BasePriceList
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array(
        'purchase' => array(self::HAS_MANY, 'Purchase', 'price_list_id'),

        'user_log' => array(self::BELONGS_TO, 'User', 'user_update_id'),
        );
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Price|Price list', $n);
    }

    public function attributeLabels()
    {
        return CMap::mergeArray(parent::attributeLabels(), array('user_update_id' => Yii::t('app', 'User|Users', 1)));
    }

    /*
    * Truncate Table
    */
    public function truncateTable()
    {
        $this->getDbConnection()->createCommand()->truncateTable($this->tableName());
    }

    /**
     * Mantiene la base de datos de lista de precios con paridad en el webservice
     * gracias al atributo 'imeiws_name'
     * @param  string $imeiws_name Nombre del equipo en el webservice
     * @param  string $brand       Nombre de la marca en la lista de precios
     * @param  string $model       Nombre del modelo en la lista de precios
     */
    public function matchWithImeiWebservice($imeiws_name, $brand, $model)
    {
        // TODO: Lo que va aca adentro 26-06-2015
    }
}
