<?php

/**
 * This is the model base class for the table "forecast".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Forecast".
 *
 * Columns in table "forecast" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $id
 * @property integer $month
 * @property integer $year
 * @property string $quantity
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_update_id
 *
 */
abstract class BaseForecast extends GxActiveRecord {

	public $created_log_field = 'created_at';

	public $updated_log_field = 'updated_at';

	public $user_update_log_field = 'user_update_id';
	

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'forecast';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Forecast|Forecasts', $n);
	}

	public static function representingColumn() {
		return 'created_at';
	}

	public function rules() {
		return array(
			array('month, year, quantity', 'required'),
			array('month, year', 'numerical', 'integerOnly'=>true),
			array('quantity', 'length', 'max'=>20),
			array('user_update_id', 'length', 'max'=>10),
			array('created_at, updated_at', 'safe'),
			array('created_at, updated_at, user_update_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, month, year, quantity, created_at, updated_at, user_update_id', 'safe', 'on'=>'search'),
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
			'month' => Yii::t('app', 'Month'),
			'year' => Yii::t('app', 'Year'),
			'quantity' => Yii::t('app', 'Quantity'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'user_update_id' => Yii::t('app', 'User Update'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id, true);
		$criteria->compare('t.month', $this->month);
		$criteria->compare('t.year', $this->year);
		$criteria->compare('t.quantity', $this->quantity, true);
		$criteria->compare('t.created_at', $this->created_at, true);
		$criteria->compare('t.updated_at', $this->updated_at, true);
		$criteria->compare('t.user_update_id', $this->user_update_id, true);

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