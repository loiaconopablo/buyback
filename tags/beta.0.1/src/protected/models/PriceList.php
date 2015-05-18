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

    // public function getBrandsList()
    // {
    // 	$criteria = new CDbCriteria;

    // 	$criteria->distinct = true;
    // 	//$criteria->compare('brand', $this->brand, true);
    // 	$criteria->select = 'brand';

    // 	return new CActiveDataProvider($this, array(
    // 		'criteria' => $criteria,
    // 	));
    // }

    public function getBrandsList() 
    {
        $model = $this->findAll(
            array(
            'distinct' => true,
            'select' => array('brand'),
            'order' => 'brand ASC',
            )
        );

        return $model;
    }

    public function getModelsByBrand($brand = null) 
    {
        $model = $this->findAll(
            array(
            'distinct' => true,
            'select' => array('model'),
            'condition' => 'brand = :brand',
            'params' => array(':brand' => $brand),
            'order' => 'model ASC',
            )
        );

        return $model;
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
}