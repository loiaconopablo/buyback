<?php

/**
 * This is the model base class for the table "user".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "User".
 *
 * Columns in table "user" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $id
 * @property string $point_of_sale_id
 * @property string $company_id
 * @property string $username
 * @property string $password
 * @property string $mail
 * @property string $employee_identification
 * @property string $created_at
 * @property string $updated_at
 * @property string $last_login
 * @property string $user_update_id
 * @property integer $is_password_validated
 */
abstract class BaseUser extends GxActiveRecord
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
        return 'user';
    }

    public static function label($n = 1) 
    {
        return Yii::t('app', 'User|Users', $n);
    }

    public static function representingColumn() 
    {
        return 'username';
    }

    public function rules() 
    {
        return array(
        array('username, password', 'required'),
        array('is_password_validated', 'numerical', 'integerOnly'=>true),
        array('point_of_sale_id, company_id, user_update_id', 'length', 'max'=>10),
        array('username, mail', 'length', 'max'=>255),
        array('password', 'length', 'min'=>6),
        array('employee_identification', 'length', 'max'=>20),
        array('created_at, updated_at, last_login', 'safe'),
        array('point_of_sale_id, company_id, mail, employee_identification, created_at, updated_at, last_login, user_update_id, is_password_validated', 'default', 'setOnEmpty' => true, 'value' => null),
        array('id, point_of_sale_id, company_id, username, password, mail, employee_identification, created_at, updated_at, last_login, user_update_id, is_password_validated', 'safe', 'on'=>'search'),
        array('old_password, new_password, repeat_password', 'required', 'on' => 'changePwd'),
        array('old_password', 'findPasswords', 'on' => 'changePwd'),
        array('repeat_password', 'compare', 'compareAttribute'=>'new_password', 'on'=>'changePwd'),
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
        'point_of_sale_id' => null,
        'company_id' => null,
        'username' => Yii::t('app', 'Username'),
        'password' => Yii::t('app', 'Password'),
        'mail' => Yii::t('app', 'Mail'),
        'employee_identification' => Yii::t('app', 'Employee Identification'),
        'created_at' => Yii::t('app', 'Created At'),
        'updated_at' => Yii::t('app', 'Updated At'),
        'last_login' => Yii::t('app', 'Last Login'),
        'user_update_id' => Yii::t('app', 'User Update'),
        'is_password_validated' => Yii::t('app', 'Is Password Validated'),
        'old_password'=>'Password actual',
        'new_password'=>'Nuevo Password',
        'repeat_password'=>'Nuevo Password(repitalo)'
        );
    }

    public function search() 
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('point_of_sale_id', $this->point_of_sale_id);
        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('mail', $this->mail, true);
        $criteria->compare('employee_identification', $this->employee_identification, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('last_login', $this->last_login, true);
        $criteria->compare('user_update_id', $this->user_update_id, true);
        $criteria->compare('is_password_validated', $this->is_password_validated);

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