<?php

/**
 * This is the model base class for the table "device_status".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "DeviceStatus".
 *
 * Columns in table "device_status" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $id
 * @property string $slug
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_update_id
 */
abstract class BaseDeviceStatus extends GxActiveRecord
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
        return 'device_status';
    }

    public static function label($n = 1) 
    {
        return Yii::t('app', 'DeviceStatus|DeviceStatuses', $n);
    }

    public static function representingColumn() 
    {
        return 'slug';
    }

    public function rules() 
    {
        return array(
        array('slug, name', 'required'),
        array('slug', 'length', 'max'=>20),
        array('name', 'length', 'max'=>40),
        array('user_update_id', 'length', 'max'=>10),
        array('created_at, updated_at', 'safe'),
        array('created_at, updated_at, user_update_id', 'default', 'setOnEmpty' => true, 'value' => null),
        array('id, slug, name, created_at, updated_at, user_update_id', 'safe', 'on'=>'search'),
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
        'slug' => Yii::t('app', 'Slug'),
        'name' => Yii::t('app', 'Name'),
        'created_at' => Yii::t('app', 'Created At'),
        'updated_at' => Yii::t('app', 'Updated At'),
        'user_update_id' => Yii::t('app', 'User Update'),
        );
    }

    public function search() 
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('user_update_id', $this->user_update_id, true);

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