<?php

Yii::import('application.models._base.BaseUser');
Yii::import('application.modules.rights.models.Authassignment');

class User extends BaseUser {

	public $old_password;
	public $new_password;
	public $repeat_password;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public static function getArrayOfAllowedUSersIdToAdmin() {
		$criteria = new CDbCriteria;
		$criteria->select = 't.userid'; // select fields which you want in output
		$criteria->addInCondition('itemname', array('admin', 'supervisor', 'retail', 'personal','compamyadmin'));

		$users = Authassignment::model()->findAll($criteria);

		$ids = array();

		foreach ($users as $user) {
			$ids[] = $user->userid;
		}

		return $ids;
	}

	public function relations() {
		return array(
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'point_of_sale' => array(self::BELONGS_TO, 'PointOfSale', 'point_of_sale_id'),

			'dispatch_note' => array(self::HAS_MANY, 'DispatchNote', 'user_create_id'),
			'purchase' => array(self::HAS_MANY, 'Purchase', 'user_id'),

			/* Log relations */
			'carrier_log' => array(self::HAS_MANY, 'Carrier', 'user_update_id'),
			'company_log' => array(self::HAS_MANY, 'Company', 'user_update_id'),
			'contract_log' => array(self::HAS_MANY, 'Contract', 'user_update_id'),
			'device_status_log' => array(self::HAS_MANY, 'DeviceStatus', 'user_update_id'),
			'distpatch_note_log' => array(self::HAS_MANY, 'DispatchNote', 'user_update_id'),
			'point_of_sale_log' => array(self::HAS_MANY, 'PointOfSale', 'user_update_id'),
			'price_list_log' => array(self::HAS_MANY, 'PriceList', 'user_update_id'),
			'purchase_log' => array(self::HAS_MANY, 'Purchase', 'user_update_id'),
			'purchase_status_log' => array(self::HAS_MANY, 'PurchaseStatus', 'user_update_id'),
			'seller_log' => array(self::HAS_MANY, 'Seller', 'user_update_id'),
			'status_log' => array(self::HAS_MANY, 'Status', 'user_update_id'),

			'authassignment' => array(self::HAS_MANY, 'Authassignment', 'userid'),
			'user_log' => array(self::BELONGS_TO, 'User', 'user_update_id'),
		);
	}

	public function rules() {
		return CMap::mergeArray(parent::rules(),
			array(
				array('username', 'unique'),
				array('company_id, point_of_sale_id', 'validarCompayAndPointOfSale'),
				array('mail', 'email'),
			)
		);
	}

	public function validarCompayAndPointOfSale($attribute, $params) {
		if (!$this->$attribute) {
			$this->addError($attribute, 'Error en la seleccion de la compañia o punto de venta');
		}
		//die(var_dump($this->$attribute));
	}

	protected function beforeSave() {

		if ($this->isNewRecord) {
			$this->password = $this->hashPassword($this->password);
		} else {
			if (!empty($this->password)) {
				if (!isset($this->new_password)) {
//si no viene de changepassword
					$this->password = $this->hashPassword($this->password);
				} else {
// viene de changepassword
					$this->is_password_validated = 1;
				}
			}
		}
		$this->username = strtolower($this->username);
		return parent::beforeSave();
	}

	/**
	 * ADMIN DataProvider
	 */
	public function admin() {

		if (!Yii::app()->user->checkAccess('admin')) {
			return false;
		}
		$criteria = $this->search()->getCriteria();

		if (!Yii::app()->user->checkAccess('superuser')) {
			$criteria->addInCondition('id', self::getArrayOfAllowedUSersIdToAdmin());
		}


		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function findPasswords($attribute, $params) {
		$user = User::model()->findByPk(Yii::app()->user->id);
		//if ($user->password != md5($this->old_password))
		if (!($this->validateOldPassword($this->old_password, $user->password))) {
			$this->addError($attribute, 'El password es incorrecto.');
		}

	}

	public function validateOldPassword($password_old, $password) {
		return CPasswordHelper::verifyPassword($password_old, $password);
	}

	public function validatePassword($password) {
		return CPasswordHelper::verifyPassword($password, $this->password);
	}

	public function hashPassword($password) {
		return CPasswordHelper::hashPassword($password);
	}

	public function getListData() {
		$criteria = new CDbCriteria;
		if (Yii::app()->user->checkAccess('admin')) {
			$criteria->addInCondition('id', self::getArrayOfAllowedUSersIdToAdmin());
		}
		return $this->findAll($criteria, true);
	}

	public function attributeLabels() {
		return CMap::mergeArray(parent::attributeLabels(), array(
			'user_update_id' => Yii::t('app', 'User|Users', 1),
			'company_id' => Yii::t('app', 'Company|Companies', 1),
			'point_of_sale_id' => Yii::t('app', 'Headquarter|Headquarters', 1),
		));
	}
}