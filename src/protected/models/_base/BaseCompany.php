<?php

/**
 * This is the model base class for the table "company".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Company".
 *
 * Columns in table "company" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $id
 * @property string $name
 * @property string $social_reason
 * @property string $cuit
 * @property string $address
 * @property string $province
 * @property string $locality
 * @property string $phone
 * @property string $mail
 * @property string $percent_fee
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_update_id
 * @property string $company_code
 * @property string $reference_name
 * @property string $reference_phone
 * @property string $reference_mail
 * @property string $last_contract_number
 * @property integer $is_owner
 * @property string $last_dispatch_note_number
 */
abstract class BaseCompany extends GxActiveRecord
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
        return 'company';
    }

    public static function label($n = 1) 
    {
        return Yii::t('app', 'Company|Companies', $n);
    }

    public static function representingColumn() 
    {
        return 'name';
    }

    public function rules() 
    {
        return array(
        array('name, social_reason, cuit, address, province, company_code', 'required'),
        array('is_owner', 'numerical', 'integerOnly'=>true),
        array('name, social_reason, address, province, locality, phone, mail, reference_name, reference_phone, reference_mail', 'length', 'max'=>255),
        array('cuit', 'length', 'max'=>11),
        array('percent_fee', 'length', 'max'=>6),
        array('user_update_id', 'length', 'max'=>10),
        array('company_code', 'length', 'max'=>100),
        array('last_contract_number, last_dispatch_note_number', 'length', 'max'=>20),
        array('created_at, updated_at', 'safe'),
        array('locality, phone, mail, percent_fee, created_at, updated_at, user_update_id, reference_name, reference_phone, reference_mail, last_contract_number, is_owner, last_dispatch_note_number', 'default', 'setOnEmpty' => true, 'value' => null),
        array('id, name, social_reason, cuit, address, province, locality, phone, mail, percent_fee, created_at, updated_at, user_update_id, company_code, reference_name, reference_phone, reference_mail, last_contract_number, is_owner, last_dispatch_note_number', 'safe', 'on'=>'search'),
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
        'social_reason' => Yii::t('app', 'Social Reason'),
        'cuit' => Yii::t('app', 'Cuit'),
        'address' => Yii::t('app', 'Address'),
        'province' => Yii::t('app', 'Province'),
        'locality' => Yii::t('app', 'Locality'),
        'phone' => Yii::t('app', 'Phone'),
        'mail' => Yii::t('app', 'Mail'),
        'percent_fee' => Yii::t('app', 'Percent Fee'),
        'created_at' => Yii::t('app', 'Created At'),
        'updated_at' => Yii::t('app', 'Updated At'),
        'user_update_id' => Yii::t('app', 'User Update'),
        'company_code' => Yii::t('app', 'Company Code'),
        'reference_name' => Yii::t('app', 'Reference Name'),
        'reference_phone' => Yii::t('app', 'Teléfono'),
        'reference_mail' => Yii::t('app', 'Mail'),
        'last_contract_number' => Yii::t('app', 'Last Contract Number'),
        'is_owner' => Yii::t('app', 'Is Owner'),
        'last_dispatch_note_number' => Yii::t('app', 'Last Dispatch Note Number'),
        );
    }

    public function search() 
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('social_reason', $this->social_reason, true);
        $criteria->compare('cuit', $this->cuit, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('province', $this->province, true);
        $criteria->compare('locality', $this->locality, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('mail', $this->mail, true);
        $criteria->compare('percent_fee', $this->percent_fee, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('user_update_id', $this->user_update_id, true);
        $criteria->compare('company_code', $this->company_code, true);
        $criteria->compare('reference_name', $this->reference_name, true);
        $criteria->compare('reference_phone', $this->reference_phone, true);
        $criteria->compare('reference_mail', $this->reference_mail, true);
        $criteria->compare('last_contract_number', $this->last_contract_number, true);
        $criteria->compare('is_owner', $this->is_owner);
        $criteria->compare('last_dispatch_note_number', $this->last_dispatch_note_number, true);

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