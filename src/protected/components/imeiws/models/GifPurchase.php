<?php
class GifPurchase
{
    /**
     * Usuario del webservice
     * @var string
     */
    public $user = '';
    /**
     * Password del usuario del webservice
     * @var string
     */
    public $password = '';
    /**
     * ID del registro a enviar
     * @var integer
     */
    public $purchase_id = null;
    /**
     * ID de la empresa
     * @var string integer
     */
    public $purchase_company_id = null;
    /**
     * ID del punto de venta que efectuó la compra
     * @var integer
     */
    public $purchase_point_of_sale_id = null;
    /**
     * ID del Punto de Venta Cabecera
     * @var integer
     */
    public $purchase_headquarter_id = null;
    /**
     * ID del usuario de buyback que compro el equipo
     * @var integer
     */
    public $purchase_user_create_id = null;
    /**
     * ID del cliente que vendió el equipo
     * @var integer
     */
    public $purchase_seller_id = null;
    /**
     * ID del Operador
     * @var integer
     */
    public $purchase_carrier_id = null;
    /**
     * IMEI del equipo comprado
     * @var string
     */
    public $purchase_imei = '';
    /**
     * Marca del equipo comprado
     * @var string
     */
    public $purchase_brand = '';
    /**
     * Modelo del equipo comprado
     * @var string
     */
    public $purchase_model = '';
    /**
     * Nombre del operador
     * @var string
     */
    public $purchase_carrier_name = '';
    /**
     * Tipo de precio [locked, unlocked]
     * @var string
     */
    public $purchase_price_type = '';
    /**
     * valor del equipo al momento de la compra
     * @var float
     */
    public $purchase_price = null;
    /**
     * TimeStamp de la compra
     * @var string
     */
    public $purchase_created_at = '';
    /**
     * Numero de contrato ej. 00124-00000025
     * @var string
     */
    public $purchase_contract_number = '';
    /**
     * CAE afip
     * @var string
     */
    public $purchase_cae = '';
    /**
     * Nombre del cliente
     * @var string
     */
    public $seller_name = '';
    /**
     * DNI del cliente
     * @var string
     */
    public $seller_dni = '';
    /**
     * Fecha de creación del cliente (timestamp)
     * @var string
     */
    public $seller_created_at = '';
    /**
     * Dirección del cliente
     * @var string
     */
    public $seller_address = '';
    /**
     * Provincia del cliente
     * @var string
     */
    public $seller_province = '';
    /**
     * Localidad del cliente
     * @var string
     */
    public $seller_locality = '';
    /**
     * Teléfono del cliente
     * @var string
     */
    public $seller_phone = '';
    /**
     * Mail del cliente
     * @var string
     */
    public $seller_mail = '';
    /**
     * IP del usuario que efectuó la compra
     * @var string
     */
    public $user_ip = '';
    /**
     * request id de GIF al momento de chequear el IMEI
     * @var string
     */
    public $gif_request_id = '';

    /**
     * Devuelve el modelo en formato JSON
     * @return json
     */
    public function toJson()
    {
        return CJSON::encode($this->toArray());
    }

    /**
     * Devuelve el modelo en un array
     * @return array
     */
    public function toArray()
    {
        return array(
            'user' => $this->user,
            'password' => $this->password,
            'purchase_id' => $this->purchase_id,
            'purchase_company_id' => $this->purchase_company_id,
            'purchase_point_of_sale_id' => $this->purchase_point_of_sale_id,
            'purchase_headquarter_id' => $this->purchase_headquarter_id,
            'purchase_user_create_id' => $this->purchase_user_create_id,
            'purchase_seller_id' => $this->purchase_seller_id,
            'purchase_carrier_id' => $this->purchase_carrier_id,
            'purchase_imei' => $this->purchase_imei,
            'purchase_brand'  => $this->purchase_brand,
            'purchase_model' => $this->purchase_model,
            'purchase_carrier_name' => $this->purchase_carrier_name,
            'purchase_price_type' => $this->purchase_price_type,
            'purchase_price' => $this->purchase_price,
            'purchase_created_at' => $this->purchase_created_at,
            'purchase_contract_number' => $this->purchase_contract_number,
            'purchase_cae' => $this->purchase_cae,
            'seller_name' => $this->seller_name,
            'seller_dni' => $this->seller_dni,
            'seller_created_at' => $this->seller_created_at,
            'seller_address' => $this->seller_address,
            'seller_province' => $this->seller_province,
            'seller_locality' => $this->seller_locality,
            'seller_phone' => $this->seller_phone,
            'seller_mail' => $this->seller_mail,
            'user_ip' => $this->user_ip,
            'gif_request_id' => $this->gif_request_id,
        );
    }
}
