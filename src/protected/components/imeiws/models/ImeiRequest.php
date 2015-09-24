<?php
class ImeiRequest
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
     * IMEI a consultar en el webservice
     * @var string <= 17 caracteres
     */
    public $imeinumber = '';
    /**
     * DNI del cliente
     * @var string <= 20 caracteres
     */
    public $fiscal_number = '';
    /**
     * Nombre del cliente
     * @var string <= 100 caracteres
     */
    public $name = '';
    /**
     * ID de la empresa compradora Compani.id
     * @var integer
     */
    public $customer_id = null;
    /**
     * ID del Punto de Venta PointOfSale.id
     * @var integer
     */
    public $terminal_id = null;



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
     * ID del Punto de Venta Cabecera
     * @var integer
     */
    public $user_ip = '';
    /**
     * request id de GIF al momento de chequear el IMEI
     * @var string
     */
    public $purchase_user_create_id = null;
    /**
     * ID del cliente que vendió el equipo
     * @var integer
     */

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
            'imeinumber' => $this->imeinumber,
            'fiscal_number' => $this->fiscal_number,
            'name' => $this->name,
            'customer_id' => $this->customer_id,
            'terminal_id' => $this->terminal_id,
            'purchase_company_id' => $this->purchase_company_id,
            'purchase_point_of_sale_id' => $this->purchase_point_of_sale_id,
            'purchase_headquarter_id' => $this->purchase_headquarter_id,
            'user_ip' => $this->user_ip,
            'purchase_user_create_id' => $this->purchase_user_create_id,
        );
    }
}
