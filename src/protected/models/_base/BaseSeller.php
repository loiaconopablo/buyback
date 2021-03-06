<?php

/**
 * This is the model base class for the table "seller".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Seller".
 *
 * Columns in table "seller" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $id
 * @property string $name
 * @property integer $dni
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_update_id
 * @property string $address
 * @property string $province
 * @property string $locality
 * @property string $phone
 * @property string $mail
 */
abstract class BaseSeller extends GxActiveRecord
{

    public $created_log_field = 'created_at';

    public $updated_log_field = 'updated_at';

    public $user_update_log_field = 'user_update_id';
    

    public static function model($className=__CLASS__) 
    {
        return parent::model($className);
    }

    public function tableName() 
    {
        return 'seller';
    }

    public static function label($n = 1) 
    {
        return Yii::t('app', 'Seller|Sellers', $n);
    }

    public static function representingColumn() 
    {
        return 'name';
    }

    public function rules() 
    {
        return array(
        array('name, dni, address, province, locality, mail', 'required'),
        array('dni', 'numerical', 'integerOnly'=>true),
        array('name, address, province, locality, phone, mail', 'length', 'max'=>255),
        array('user_update_id', 'length', 'max'=>10),
        array('created_at, updated_at', 'safe'),
        array('created_at, updated_at, user_update_id, phone', 'default', 'setOnEmpty' => true, 'value' => null),
        array('id, name, dni, created_at, updated_at, user_update_id, address, province, locality, phone, mail', 'safe', 'on'=>'search'),
        );
    }

    public function relations() 
    {
        return array(
        );
    }

    public function pivotModels() 
    {
        return array(
        );
    }

    public function attributeLabels() 
    {
        return array(
        'id' => Yii::t('app', 'ID'),
        'name' => Yii::t('app', 'Name'),
        'dni' => Yii::t('app', 'Dni'),
        'created_at' => Yii::t('app', 'Created At'),
        'updated_at' => Yii::t('app', 'Updated At'),
        'user_update_id' => Yii::t('app', 'User Update'),
        'address' => Yii::t('app', 'Address'),
        'province' => Yii::t('app', 'Province'),
        'locality' => Yii::t('app', 'Locality'),
        'phone' => Yii::t('app', 'Phone'),
        'mail' => Yii::t('app', 'Mail'),
        );
    }

    public function search() 
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('dni', $this->dni);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('user_update_id', $this->user_update_id, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('province', $this->province, true);
        $criteria->compare('locality', $this->locality, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('mail', $this->mail, true);

        return new CActiveDataProvider(
            $this, array(
            'criteria' => $criteria,
            )
        );
    }

    /**
    *    Autolog some fields if exists
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