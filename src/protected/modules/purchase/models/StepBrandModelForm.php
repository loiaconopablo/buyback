<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class StepBrandModelForm extends CFormModel
{
    public $brand;
    public $model;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
        // username and password are required
        array('brand, model', 'required'),


        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
        'brand' => Yii::t('app', 'Marca'),
        'model' => Yii::t('app', 'Modelo'),
        );
    }
}
