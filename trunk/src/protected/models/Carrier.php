<?php

Yii::import('application.models._base.BaseCarrier');

class Carrier extends BaseCarrier
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'purchase' => array(self::HAS_MANY, 'Contract', 'carrier_id'),
			
			'user_log' => array(self::BELONGS_TO, 'User', 'user_update_id'),
		);
	}

	public function attributeLabels()
	{
		return CMap::mergeArray(parent::attributeLabels(), array('user_update_id' => Yii::t('app', 'User|Users', 1)));
	}

}