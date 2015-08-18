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
     * La url del webservice para postear una compra
     * @var string
     */
    public $url_post_purchase = '';

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

        return $output;
    }

    /**
     * Crea una entrada en el webservice de GIF para registrar una compra
     * @param  Purchase AR $purchase El registro que se acaba de guardar de Purchase
     * @return boolean
     */
    public function postPurchase($purchase)
    {
        $post_purchase = new GifPurchase();

        $post_purchase->user = $this->credentials['user'];
        $post_purchase->password = $this->credentials['password'];

        $post_purchase->purchase_id = $purchase->id;
        $post_purchase->purchase_company_id = $purchase->company_id;
        $post_purchase->purchase_point_of_sale_id = $purchase->point_of_sale_id;
        $post_purchase->purchase_headquarter_id = $purchase->headquarter_id;
        $post_purchase->purchase_user_create_id = $purchase->user_create_id;
        $post_purchase->purchase_seller_id = $purchase->seller_id;
        $post_purchase->purchase_carrier_id = $purchase->carrier_id;
        $post_purchase->purchase_imei = $purchase->imei;
        $post_purchase->purchase_brand = $purchase->brand;
        $post_purchase->purchase_model = $purchase->model;
        $post_purchase->purchase_carrier_name = $purchase->carrier_name;
        $post_purchase->purchase_price_type = $purchase->price_type;
        $post_purchase->purchase_price = $purchase->purchase_price;
        $post_purchase->purchase_created_at = $purchase->created_at;
        $post_purchase->purchase_contract_number = $purchase->contract_number;
        $post_purchase->purchase_cae = $purchase->cae;
        $post_purchase->seller_name = $purchase->seller->name;
        $post_purchase->seller_dni = $purchase->seller->dni;
        $post_purchase->seller_created_at = $purchase->seller->created_at;
        $post_purchase->seller_address = $purchase->seller->address;
        $post_purchase->seller_province = $purchase->seller->province;
        $post_purchase->seller_locality = $purchase->seller->locality;
        $post_purchase->seller_phone = $purchase->seller->phone;
        $post_purchase->seller_mail = $purchase->seller->mail;
        $post_purchase->user_ip = $purchase->user_ip;
        $post_purchase->gif_request_id = $purchase->getGifRequestId();

        $output = Yii::app()->curl->setOption(CURLOPT_HTTPHEADER, array())->post($this->url_post_purchase, $post_purchase->toArray());

        return $output;
    }
}