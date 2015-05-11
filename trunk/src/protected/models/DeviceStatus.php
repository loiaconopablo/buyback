<?php

Yii::import('application.models._base.BaseDeviceStatus');

class DeviceStatus extends BaseDeviceStatus
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'contract' => array(self::HAS_MANY, 'Contract', 'device_status_id'),

			'user_log' => array(self::BELONGS_TO, 'User', 'user_update_id'),
		);
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Device status|Device statuses', $n);
	}

	public function attributeLabels()
	{
		return CMap::mergeArray(parent::attributeLabels(), array('user_update_id' => Yii::t('app', 'User|Users', 1)));
	}
}