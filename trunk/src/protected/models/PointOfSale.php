<?php

Yii::import('application.models._base.BasePointOfSale');

class PointOfSale extends BasePointOfSale {
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function relations() {
		return array(
			'purchases_headquarter' => array(self::HAS_MANY, 'Purchase', 'headquarter_id'),
			'purchases_point_of_sale' => array(self::HAS_MANY, 'Purchase', 'point_of_sale_id'),
			'dispatch_notes_source' => array(self::HAS_MANY, 'DispatchNote', 'source_id'),
			'dispatch_notes_destinantio' => array(self::HAS_MANY, 'DispatchNote', 'destination_id'),
			'users' => array(self::HAS_MANY, 'User', 'point_of_sale_id'),
			'purchases_status_point_of_sale' => array(self::HAS_MANY, 'PurchaseStatus', 'point_of_sale_id'),
			'purchases_status_headquarter' => array(self::HAS_MANY, 'PurchaseStatus', 'headquarter_id'),

			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'headquarter' => array(self::BELONGS_TO, 'PointOfSale', 'headquarter_id'),
			'user_log' => array(self::BELONGS_TO, 'User', 'user_update_id'),
		);
	}

	public function rules() {
		return CMap::mergeArray(parent::rules(),
			array(
				array('headquarter_id', 'validateHeadquarter'),
				array('mail', 'email'),
			)
		);
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Point of sale|Points of sale', $n);
	}

	public function getHeadquartersByCompany($company_id) {
		$model = $this->findAllByAttributes(
			array(
				'company_id' => $company_id,
				'is_headquarter' => 1,
			),
			array('order' => 'name ASC')
		);
		return $model;
	}

	public function getPointsOfSaleByCompany($company_id) {
		$model = $this->findAllByAttributes(
			array(
				'company_id' => $company_id,
			),
			array('order' => 'name ASC')
		);

		return $model;
	}

	public function validateHeadquarter($attribute, $params) {

		if (!$this->is_headquarter) {
			if ($this->$attribute) {
				return true;
			} else {
				$this->addError($attribute, 'Debe seleccionar una cabecera');
			}
		} else {
			return true;
		}
	}

	// TODO: esto no va mas creo 16-02-2015
	// public function afterSave()
	// {
	// 	if ($this->is_headquarter) {
	// 		$this->isNewRecord = false;
	// 		$this->headquarter_id = $this->id;
	// 		$this->saveAttributes(array('headquarter_id'));
	// 	}
	// }

	public function attributeLabels() {
		return CMap::mergeArray(parent::attributeLabels(),
			array(
				'user_update_id' => Yii::t('app', 'User|Users', 1),
				'headquarter' => Yii::t('app', 'Headquarter|Headquarters', 1),
			)
		);
	}
}