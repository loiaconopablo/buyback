<?php

Yii::import('application.models._base.BaseForecast');

class Forecast extends BaseForecast
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function attributeLabels()
    {
        return CMap::mergeArray(
            parent::attributeLabels(),
            array(
            'user_update_id' => Yii::t('app', 'User|Users', 1),
            'user_create_id' => Yii::t('app', 'Usuario'),
            'month' => Yii::t('app', 'Mes'),
            'year' => Yii::t('app', 'Año'),
            'quantity' => Yii::t('app', 'Cantidad'),
            )
        );
    }
}