<?php

/**
 * This is the model base class for the table "counters".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Counters".
 *
 * Columns in table "counters" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $id
 * @property string $description
 * @property string $quantity
 *
 */
abstract class BaseCounters extends GxActiveRecord {

	public $created_log_field = 'created_at';

	public $updated_log_field = 'updated_at';

	public $user_update_log_field = 'user_update_id';
	

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'counters';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Counters|Counters', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			array('id', 'required'),
			array('id, quantity', 'length', 'max'=>20),
			array('description', 'safe'),
			array('description, quantity', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, description, quantity', 'safe', 'on'=>'search'),
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
			'description' => Yii::t('app', 'Description'),
			'quantity' => Yii::t('app', 'Quantity'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id, true);
		$criteria->compare('t.description', $this->description, true);
		$criteria->compare('t.quantity', $this->quantity, true);

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