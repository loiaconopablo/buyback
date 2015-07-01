<?php
/**
 * Esta clase se comunica con el webservice de imei
 * @author RGG
 */

Yii::import('application.components.imeiws.models.*', true);

class IMEIws extends CApplicationComponent
{
    
    /**
     * La url del webservice
     * @var string
     */
    public $url = '';

    /**
     * Credenciales para acceder al servicio
     * @var array
     */
    public $credentials = array();


    /**
     * Inicia el componente
     */
    public function init()
    {
        
    }

    /**
     * Chequea el imei contra el webservice
     * @return [type] Devuelve los datos otorgados por el websercice o false
     */
    public function check($imei)
    {
        $request = new ImeiRequest();

        $request->user = $this->credentials['user'];
        $request->password = $this->credentials['password'];

        $request->imeinumber = $imei;
                
        $output = Yii::app()->curl->setOption(CURLOPT_HTTPHEADER, array())->post($this->url, $request->toArray());

        return CJSON::decode($output, false);
    }
}
