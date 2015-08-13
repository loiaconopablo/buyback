<?php

class CheckDeviceForm extends CFormModel
{
    public $brand;
    public $model;
    public $peoplesoft_order;
    public $blacklist;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
        // username and password are required
        array('brand, model, peoplesoft_order', 'required'),


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
