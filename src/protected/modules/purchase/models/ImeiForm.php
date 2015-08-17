<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ImeiForm extends CFormModel
{
    public $imei_checked;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('imei_checked', 'required'),
            array('imei_checked', 'validateImeiFormat'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
        'imei_checked' => 'IMEI',
        );
    }

    /**
     * Valida que el imai tenga un formato valido
     * @param  [type] $attribute [description]
     * @param  [type] $params    [description]
     */
    public function validateImeiFormat($attribute, $params)
    {
        //Luhn' s algorithm
        $number = $this->imei_checked;

        settype($number, 'string');

        $sumTable = array(
        array(0,1,2,3,4,5,6,7,8,9),
        array(0,2,4,6,8,1,3,5,7,9)
        );

        $sum = 0;
        $flip = 0;

        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $sum += $sumTable[$flip++ & 0x1][$number[$i]];
        }

        if (!(($sum % 10) === 0)) {
            $this->addError($attribute, Yii::t('app', 'IMEI Formato invalido.'));
        }
    }
}
