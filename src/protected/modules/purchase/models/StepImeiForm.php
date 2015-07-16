<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class StepImeiForm extends CFormModel
{
    public $imei;
    public $gif_data ;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('imei', 'required'),
            array('imei', 'validateImeiFormat'),
            array('imei', 'validateImeiBlacklist'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
        'imei' => 'IMEI',
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
        $number = $this->imei;

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
            $this->addError($attribute, 'IMEI Formato invalido.');
        }
    }


    /**
     * Valida que el imei contra el webservice para ver si no esta en la blacklist
     * @param  [type] $attribute [description]
     * @param  [type] $params    [description]
     */
    public function validateImeiBlacklist($attribute, $params)
    {
        $imeiws_response_json = Yii::app()->imeiws->check($this->imei);

        $imeiws_response = CJSON::decode($imeiws_response_json, false);

        if ($imeiws_response->error !== 0) {
            // No valida como negativo pero loguea que hubo un error utilizando el webservice
            Yii::log('IMEI WEBSERVICE', CLogger::LEVEL_ERROR, $imeiws_response->error_desc);

            return true;
        }

        if (strtoupper(trim($imeiws_response->respuesta->blacklist)) == 'YES') {
            $this->addError($attribute, 'El equipo no se puede comprar. Validar con el operador.');
        }

        // Guarda la respuesta del webservice
        // para que la aplicacion lo pueda usar para matchar con sus equipos en la lista de precios
        $this->gif_data = $imeiws_response_json;
    }
}
