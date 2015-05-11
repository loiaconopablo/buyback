<?php

Yii::import('application.models._base.BaseSeller');

class Seller extends BaseSeller
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'purchase'             => array(self::HAS_MANY, 'Purchase', 'seller_id'),

			'user_log'             => array(self::BELONGS_TO, 'User', 'user_update_id'),
		);
	}

	public function rules()
	{
		return CMap::mergeArray(parent::rules(),
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
		return CMap::mergeArray(parent::attributeLabels(), array(
			'user_update_id' => Yii::t('app', 'User|Users', 1),
			'name' => 'Apellido y Nombre',
			));
	}

}