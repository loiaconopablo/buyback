<?php

Yii::import('application.models._base.BaseSeller');

class Seller extends BaseSeller
{
    public static function model($className=__CLASS__) 
    {
        return parent::model($className);
    }

    public function relations() 
    {
        return array(
        'purchase'             => array(self::HAS_MANY, 'Purchase', 'seller_id'),

        'user_log'             => array(self::BELONGS_TO, 'User', 'user_update_id'),
        );
    }

    public function rules()
    {
        return CMap::mergeArray(
            parent::rules(),
            array(
            array('dni', 'length', 'is'=>8),
            array(
            'dni','numerical',
                    'integerOnly'=>true,
            ),
            )
        );
    }

    public function attributeLabels()
    {
        return CMap::mergeArray(
            parent::attributeLabels(), array(
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Apellido y Nombre'),
            'dni' => Yii::t('app', 'DNI'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_update_id' => Yii::t('app', 'User Update'),
            'address' => Yii::t('app', 'Dirección'),
            'province' => Yii::t('app', 'Provincia'),
            'locality' => Yii::t('app', 'Localidad'),
            'phone' => Yii::t('app', 'Teléfono'),
            'mail' => Yii::t('app', 'Mail'),
            )
        );
    }

}