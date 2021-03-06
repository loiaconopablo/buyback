<?php

/**
 * This is the model base class for the table "sellingcode".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "SellingCode".
 *
 * Columns in table "sellingcode" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $id
 * @property string $brand
 * @property string $model
 * @property string $movistar_a
 * @property string $personal_a
 * @property string $claro_a
 * @property string $libre_a
 * @property string $movistar_b
 * @property string $personal_b
 * @property string $claro_b
 * @property string $libre_b
 * @property string $bad_refurbish
 * @property string $bad_irreparable
 *
 */
abstract class BaseSellingCode extends GxActiveRecord {

	public $created_log_field = 'created_at';

	public $updated_log_field = 'updated_at';

	public $user_update_log_field = 'user_update_id';
	

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'sellingcode';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'SellingCode|SellingCodes', $n);
	}

	public static function representingColumn() {
		return 'brand';
	}

	public function rules() {
		return array(
			array('brand, model', 'required'),
			array('brand, model', 'length', 'max'=>255),
			array('movistar_a, personal_a, claro_a, libre_a, movistar_b, personal_b, claro_b, libre_b, bad_refurbish, bad_irreparable', 'length', 'max'=>50),
			array('movistar_a, personal_a, claro_a, libre_a, movistar_b, personal_b, claro_b, libre_b, bad_refurbish, bad_irreparable', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, brand, model, movistar_a, personal_a, claro_a, libre_a, movistar_b, personal_b, claro_b, libre_b, bad_refurbish, bad_irreparable', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'brand' => Yii::t('app', 'Brand'),
			'model' => Yii::t('app', 'Model'),
			'movistar_a' => Yii::t('app', 'Movistar A'),
			'personal_a' => Yii::t('app', 'Personal A'),
			'claro_a' => Yii::t('app', 'Claro A'),
			'libre_a' => Yii::t('app', 'Libre A'),
			'movistar_b' => Yii::t('app', 'Movistar B'),
			'personal_b' => Yii::t('app', 'Personal B'),
			'claro_b' => Yii::t('app', 'Claro B'),
			'libre_b' => Yii::t('app', 'Libre B'),
			'bad_refurbish' => Yii::t('app', 'Bad Refurbish'),
			'bad_irreparable' => Yii::t('app', 'Bad Irreparable'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id, true);
		$criteria->compare('t.brand', $this->brand, true);
		$criteria->compare('t.model', $this->model, true);
		$criteria->compare('t.movistar_a', $this->movistar_a, true);
		$criteria->compare('t.personal_a', $this->personal_a, true);
		$criteria->compare('t.claro_a', $this->claro_a, true);
		$criteria->compare('t.libre_a', $this->libre_a, true);
		$criteria->compare('t.movistar_b', $this->movistar_b, true);
		$criteria->compare('t.personal_b', $this->personal_b, true);
		$criteria->compare('t.claro_b', $this->claro_b, true);
		$criteria->compare('t.libre_b', $this->libre_b, true);
		$criteria->compare('t.bad_refurbish', $this->bad_refurbish, true);
		$criteria->compare('t.bad_irreparable', $this->bad_irreparable, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	*	Autolog some fields if exists
	*
	*
	*/
	public function behaviors()
	{
    	return array(
        	'AutoLogBehavior' => array(
            	'class' => 'application.components.AutoLogBehavior',
            	//You can optionally set the field name options here
        	)
    	);
	}
}