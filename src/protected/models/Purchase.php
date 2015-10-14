<?php

Yii::import('application.models._base.BasePurchase');

class Purchase extends BasePurchase {

    const DEFAULT_PAID_PRICE = 0;
    const COMPROBANTE_TIPO_COMPRA = 'C';
    const COMPROBANTE_TIPO_NOTA_DE_CREDITO = 'NC';
    const COMPROBANTE_TIPO_COMPRA_MASIVA = 'CM';
    const PUNTO_DE_VENTA_COMPRA_MASIVA = '33';

    public $quantity;
    public $price_average;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return array(
            'purchase_statuses' => array(self::HAS_MANY, 'PurchaseStatus', 'purchase_id'),
            'purchase' => array(self::HAS_ONE, 'Purchase', 'associate_row'),
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'point_of_sale' => array(self::BELONGS_TO, 'PointOfSale', 'point_of_sale_id'),
            'last_location' => array(self::BELONGS_TO, 'PointOfSale', 'last_location_id'),
            'last_dispatch_note' => array(self::BELONGS_TO, 'DispatchNote', 'last_dispatch_note_id'),
            'headquarter' => array(self::BELONGS_TO, 'PointOfSale', 'headquarter_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_create_id'),
            'seller' => array(self::BELONGS_TO, 'Seller', 'seller_id'),
            'carrier' => array(self::BELONGS_TO, 'Carrier', 'carrier_id'),
            'carrier_checked' => array(self::BELONGS_TO, 'Carrier', 'carrier_id_checked'),
            'price_list' => array(self::BELONGS_TO, 'PriceList', 'price_list_id'),
            'current_status' => array(self::BELONGS_TO, 'Status', 'current_status_id'),
            'user_log' => array(self::BELONGS_TO, 'User', 'user_update_id'),
            'associate_purchase' => array(self::BELONGS_TO, 'Purchase', 'associate_row'),
            'status' => array(self::BELONGS_TO, 'Status', 'current_status_id'),
        );
    }

    public static function representingColumn() {
        return 'contract_number';
    }

    public function attributeLabels() {
        return CMap::mergeArray(
                        parent::attributeLabels(), array(
                    'user_update_id' => Yii::t('app', 'User|Users', 1),
                    'user_create_id' => Yii::t('app', 'Usuario'),
                    'contract_number' => Yii::t('app', 'Nº Contrato'),
                    'brand' => Yii::t('app', 'Marca'),
                    'imei' => Yii::t('app', 'IMEI'),
                    'model' => Yii::t('app', 'Modelo'),
                    'carrier' => Yii::t('app', 'Operador'),
                    'carrier_id' => Yii::t('app', 'Operador'),
                    'carrier_name' => Yii::t('app', 'Operador'),
                    'point_of_sale_id' => Yii::t('app', 'Punto de Venta'),
                    'user' => Yii::t('app', 'Usuario', 1),
                    'created_at' => Yii::t('app', 'F. de compra'),
                    'peoplesoft_order' => Yii::t('app', 'Nº PeopleSoft'),
                    'to_refurbish' => Yii::t('app', 'Apto para refabricación'),
                    'seller' => Yii::t('app', 'Cliente'),
                    'purchase_price' => Yii::t('app', 'Precio de compra'),
                    'paid_price' => Yii::t('app', 'Precio de liquidación'),
                    'user_ip' => Yii::t('app', 'IP'),
                    'associate_purchase' => Yii::t('app', 'Comprobante asociado'),
                    'status' => Yii::t('app', 'Estado'),
                    'brand_checked' => Yii::t('app', 'Marca confirmado'),
                    'model_checked' => Yii::t('app', 'Modelo confirmado'),
                    'carrier_checked' => Yii::t('app', 'Operador confirmado'),
                        )
        );
    }

    public function rules() {
        return CMap::mergeArray(
                        parent::rules(), array(
                    array('imei_checked, to_refurbish, brand_checked, model_checked, carrier_id', 'required', 'on' => 'checking'),
                    array('imei_checked', 'validateImeiFormat', 'on' => 'checking'),
                    array('contract_number', 'unique', 'on' => 'insert'),
                    array('paid_price', 'safe', 'on' => 'insert'),
                    array('imei', 'isDuplicate', 'on' => 'insert'),
                    array('gif_response_json', 'gifNotMatch', 'on' => 'insert'),
                    array('imei', 'validateImeiFormat'),
                        )
        );
    }

    /**
     * INICIO VALIDACIONES DE RULES
     */
    // Chequea si el equipo ya fue vendido por el mismo cliente
    public function isDuplicate($attribute, $params) {
        if (!$this->seller_id) {
            return;
        }

        $criteria = new CDbCriteria;
        $criteria->addNotInCondition('current_status_id', array(Status::CANCELLED, Status::CANCELLATION));
        $criteria->compare('imei', $this->imei);
        $equipos = $this->findAll($criteria);

        if (count($equipos)) {
            foreach ($equipos as $equipo) {

                if ($this->comprobante_tipo == self::COMPROBANTE_TIPO_COMPRA) {
                    if ($equipo->seller->dni == $this->seller->dni) {
                        $this->addError($attribute, Yii::t('app', 'El equipo ya fue comprado al mismo vendedor'));
                    }
                }

                if ($this->comprobante_tipo == self::COMPROBANTE_TIPO_COMPRA_MASIVA) {
                    if ($equipo->company->cuit == $this->company->cuit) {
                        $this->addError($attribute, Yii::t('app', 'El equipo ya fue comprado al mismo vendedor'));
                    }
                }
            }
        }
    }

    /**
     * Valida que el imai tenga un formato valido
     * @param  [type] $attribute [description]
     * @param  [type] $params    [description]
     */
    public function validateImeiFormat($attribute, $params) {
        //Luhn' s algorithm
        $number = $this->$attribute;

        settype($number, 'string');

        $sumTable = array(
            array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9),
            array(0, 2, 4, 6, 8, 1, 3, 5, 7, 9)
        );

        $sum = 0;
        $flip = 0;

        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $sum += $sumTable[$flip++ & 0x1][$number[$i]];
        }

        if (!(($sum % 10) === 0)) {
            $this->addError($attribute, Yii::t('app', $this->$attribute . ' - IMEI Formato invalido.'));
        }
    }

    /**
     * En realidad no es una validacion porque no bloquea
     * si no coincide la data de GIF con la de la compra real solo se loguea
     * TODO: avisar a un webservice de GIF
     */
    public function gifNotMatch() {
        if (strlen(trim($this->gif_response_json))) {
            $gif_response_json_obj = CJSON::decode($this->gif_response_json, false);

            if (strtoupper($gif_response_json_obj->respuesta->brand) !== strtoupper($this->brand)) {
                Yii::log('GIF_DICTIONARY brand: ' . $gif_response_json_obj->respuesta->brand . ' model: ' . $gif_response_json_obj->respuesta->model . ' | USER SELECTION brand: ' . $this->brand . ' model: ' . $this->model, CLogger::LEVEL_WARNING, 'gif_not_match');
                return;
            }

            if (strtoupper($gif_response_json_obj->respuesta->model) !== strtoupper($this->model)) {
                Yii::log('GIF_DICTIONARY brand: ' . $gif_response_json_obj->respuesta->brand . ' model: ' . $gif_response_json_obj->respuesta->model . ' | USER SELECTION brand: ' . $this->brand . ' model: ' . $this->model, CLogger::LEVEL_WARNING, 'gif_not_match');
                return;
            }
        }
    }

    /**
     * FIN VALIDACIONES DE RULES
     */

    /**
     * MODEL´S HOOCKS BEFORESAVE AFTERSAVE
     */
    protected function afterSave() {
        parent::afterSave();
        if ($this->isNewRecord) {
            // Envía datos de la nueva compra a GIF
            Yii::app()->imeiws->postPurchase($this);
        }
    }

    /**
     * END MODEL´S HOOCKS
     */
    public function searchReferences() {
        return parent::search();
    }

    public function search() {
        $criteria = parent::search()->getCriteria();

        $criteria->select = 't.*';

        $params_created = Helper::getDateFilterParams('created_at');
        $params_recived = Helper::getDateFilterParams('recived_at');
        $criteria->join = 'LEFT JOIN purchase_status AS ps ON t.id = ps.purchase_id';
        $criteria->addBetweenCondition('t.created_at', $params_created[':from'], $params_created[':to']);
        $criteria->addBetweenCondition('ps.created_at', $params_recived[':from'], $params_recived[':to']);
        $criteria->group = 't.id';


        /**
         * Filtra por estados si esta seteada la cookie
         */
        $checkedItemsArray = array();

        if (isset(Yii::app()->request->cookies['checkedPurchaseStatuses'])) {
            $checkedItemsArray = explode(',', Yii::app()->request->cookies['checkedPurchaseStatuses']->value);
        }

        $criteria->addInCondition('current_status_id', $checkedItemsArray);

        return new CActiveDataProvider(
                $this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
                )
        );
    }

    /**
     * Agrega condiciones al criterio de search para filtrar los equipos que estan en estado
     * RECEIVED o PENDING para en el point_of_sale_id del usuario de session
     * @author Richard Grinberg <rggrinberg@gmail.com>
     * @return CActiveDataProvider conjunto de reguistros que responden al criterio genenrado
     */
    public function admin() {

        $criteria = $this->search()->getCriteria();

        return $this->adminSearch($criteria);
    }

    public function adminReferences() {
        $criteria = parent::search()->getCriteria();

        return $this->adminSearch($criteria);
    }

    public function adminSearch($criteria) {
        /*
          Condiciones para mostrar solo los equipos que el usuario debe ver en esta lista
         */
        $criteria->compare('last_location_id', Yii::app()->user->point_of_sale_id);
        $criteria->addInCondition('current_status_id', array(Status::PENDING, Status::RECEIVED));

        return new CActiveDataProvider(
                $this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
                )
        );
    }

    /**
     * Agrega condiciones al criterio de search para filtrar los equipos que estan en estado
     * RECEIVED o PENDING para en el point_of_sale_id del usuario de session
     * @author Richard Grinberg <rggrinberg@gmail.com>
     * @return CActiveDataProvider conjunto de reguistros que responden al criterio genenrado
     */
    public function company() {

        $criteria = $this->search()->getCriteria();

        return $this->companySearch($criteria);
    }

    public function companyReferences() {
        $criteria = parent::search()->getCriteria();

        return $this->companySearch($criteria);
    }

    public function companySearch($criteria) {
        /*
          Condiciones para mostrar solo los equipos que el usuario debe ver en esta lista
         */
        $criteria->compare('t.company_id', Yii::app()->user->company_id);

        return new CActiveDataProvider(
                $this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
                )
        );
    }

    /**
     * Agrega condiciones al criterio de search para filtrar los equipos que estan en estado
     * @author Richard Grinberg <rggrinberg@gmail.com>
     * @return CActiveDataProvider conjunto de reguistros que responden al criterio genenrado
     */
    public function technicalsupervisor() {

        $criteria = $this->search()->getCriteria();

        return $this->technicalsupervisorSearch($criteria);
    }

    public function technicalsupervisorReferences() {
        $criteria = parent::search()->getCriteria();

        return $this->technicalsupervisorSearch($criteria);
    }

    public function technicalsupervisorSearch($criteria) {
        /*
          Condiciones para mostrar solo los equipos que el usuario debe ver en esta lista
         */
        $criteria->compare('t.last_destination_id', Yii::app()->user->point_of_sale_id);
        $criteria->addInCondition('current_status_id', array(Status::SENT, Status::PENDING_TO_BE_RECEIVED, Status::RECEIVED, Status::APPROVED, Status::REJECTED, Status::REQUOTED));

        return new CActiveDataProvider(
                $this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
                )
        );
    }

    /**
     * Guarda el estado de purchase y el correspondiente purchase_status
     * @author Richard Grinberg <rggrinberg@gmail.com>
     * @param integer $status           Es un valor de alguna de las constantes de Status
     * @param integer $dispatch_note_id Nro de la nota de envio en la que esta cuando cambia de estado. Si no esta en ninguna es 0
     * @param string  $comment          Comentario que se guarda en el estado (no en la compra 'purchase')
     */
    public function setStatus($status, $dispatch_note_id = 0, $comment = null) {
        //Acutaliza el atributo current_status_id
        $this->current_status_id = $status;

        if ($this->save()) {
            $purchase_status = new PurchaseStatus;

            $purchase_status->purchase_id = $this->id;
            $purchase_status->status_id = $this->current_status_id;
            $purchase_status->dispatch_note_id = $dispatch_note_id;
            $purchase_status->comment = $comment;

            $purchase_status->point_of_sale_id = Yii::app()->user->point_of_sale_id;
            $purchase_status->company_id = Yii::app()->user->company_id;
            $purchase_status->headquarter_id = Yii::app()->user->headquarter_id;

            if (!$purchase_status->save()) {
                throw new Exception("Error guardando estado", 1);
            }
        } else {
            throw new Exception('Error actualizando compra: ' . $this->contract_number, 1);
        }
    }

    /**
     * Pasa la compra al estado cancelado
     * Esto se dispara cuando se cancela un remito
     */
    public function setAsCancelled() {
        $this->setStatus(Status::CANCELLED, $this->last_dispatch_note_id);
    }

    /**
     * Devuelve el AR de PurchaseStatus con mayor id donde la compra tiene el estado RECEIVED
     * o null si no encuentra nada
     * @return timestamp la fecha del ultimo estado RECIVED
     */
    public function getLastRecivedDate() {
        $PurchaseStatusModel = new PurchaseStatus;

        $criteria = new CDbCriteria;
        $criteria->addCondition('purchase_id = :purchase_id');
        $criteria->addCondition('status_id = :status');
        $criteria->params = array(
            ':status' => Status::RECEIVED,
            ':purchase_id' => $this->id,
        );
        $criteria->order = 'id DESC';

        $purchase_status_model = $PurchaseStatusModel->find($criteria);

        if ($purchase_status_model) {
            return date("d-m-Y", strtotime($purchase_status_model->created_at));
        }

        return;
    }

    /**
     * Devuelve las compras concretadas entre 2 fechas
     * @param  string $from Fecha desde
     * @param  string $to   Fecha hasta
     * @return  Purcahse AR
     */
    public function getTotalPurchaseBetweenDates($from, $to) {
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('t.created_at', $from, $to);
        $criteria->addNotInCondition('t.current_status_id', array(Status::CANCELLED, Status::CANCELLATION));
        $criteria->order = 'brand';

        return $this->findAll($criteria);
    }

    /**
     * Devuelve la cantidad entre 2 fechas agrupadas por marca
     * @param  string $from Fecha desde
     * @param  string $to   Fecha hasta
     * @return  Purcahse AR
     */
    public function getBrandQuantitiesBetweenDates($from, $to) {
        $criteria = new CDbCriteria;
        $criteria->select = 't.brand, COUNT(t.id) AS "quantity"';
        $criteria->addBetweenCondition('t.created_at', $from, $to);
        $criteria->addNotInCondition('t.current_status_id', array(Status::CANCELLED, Status::CANCELLATION));
        $criteria->group = 't.brand';
        $criteria->order = 'quantity DESC';

        return $this->findAll($criteria);
    }

    /**
     * Devuelve el promedio de precio entre 2 fechas agrupadas por marca
     * @param  string $from Fecha desde
     * @param  string $to   Fecha hasta
     * @return  Purcahse AR
     */
    public function getBrandPriceAverageBetweenDates($from, $to) {
        $criteria = new CDbCriteria;
        $criteria->select = 't.brand, AVG(t.purchase_price) AS "price_average"';
        $criteria->addBetweenCondition('t.created_at', $from, $to);
        $criteria->addNotInCondition('t.current_status_id', array(Status::CANCELLED, Status::CANCELLATION));
        $criteria->group = 't.brand';
        $criteria->order = 'price_average DESC';

        return $this->findAll($criteria);
    }

    /**
     * Devuelve las compras agrupadas por punto de venta entre determinadas fecahas
     * @param  string $from Fecha desde
     * @param  string $to   Fecha hasta
     * @return Purcahse AR  Compras agrupadas por PDV
     */
    public function getWorkingPointsOfSaleBetweenDates($from, $to) {
        $criteria = new CDbCriteria;
        $criteria->select = 't.brand, COUNT(t.id) AS "quantity"';
        $criteria->addBetweenCondition('t.created_at', $from, $to);
        $criteria->addNotInCondition('t.current_status_id', array(Status::CANCELLED, Status::CANCELLATION));
        $criteria->group = 't.point_of_sale_id';
        $criteria->order = 'quantity DESC';

        return $this->findAll($criteria);
    }

    /**
     * Devuelve el precio solicitado recuperandolo del campo de log pricelist_log
     * @param  string $price_type [locked, unlocked]
     * @return integer            El precio
     */
    public function getLoggedPrice($price_type) {
        $price_log_obj = CJSON::decode($this->pricelist_log);

        if (strlen(trim($this->pricelist_log))) {
            return $price_log_obj[$price_type];
        }

        return false;
    }

    /**
     * Devuelve el request_id extrayendolo del json de la respuesta de GIF
     * @return string GIF request id
     */
    public function getGifRequestId() {
        $gif_response_json = CJSON::decode($this->gif_response_json);

        if (strlen(trim($this->gif_response_json))) {
            return $gif_response_json['respuesta']['id_request'];
        }

        return false;
    }

    /**
     * Setea el valor del campo gif_response_son
     */
    public function setGifDataAtBuy() {
        $this->gif_response_json = trim($this->getGifResponse($this->imei));

        $device = $this->setGifData('gif_response_json');

        if ($device) {
            $this->brand = $device->brand;
            $this->model = $device->model;
        }
    }

    /**
     * Setea el valor del campo gif_response_son
     */
    public function setGifDataAtChecked() {
        $this->gif_response_json_checked = trim($this->getGifResponse($this->imei_checked));

        $device = $this->setGifData('gif_response_json_checked');

        if ($device) {
            $this->brand_checked = $device->brand;
            $this->model_checked = $device->model;
        }
    }

    /**
     * Trae el json de respuesta del webservise GIF
     * @return string json
     */
    private function getGifResponse($imei) {
        if ($this->imei) {

            return Yii::app()->imeiws->check($imei);
        } else {
            throw new Exception(Yii::t('app', 'El imei es nulo no se puede buscar en GIF'), 1);
        }
    }

    /**
     * Setea los atributos blacklist, brand, model
     * Si los encuentra
     */
    private function setGifData($attribute) {
        if (!strlen(trim($this->$attribute))) {
            return false;
        }
        $gif_data = CJSON::decode($this->$attribute, false);

        if (strtoupper(trim($gif_data->respuesta->blacklist)) == 'YES') {
            // Esta en banda negativa. se marca el campo
            Yii::log('IMEI: ' . $this->imei . ' - USER: ' . Yii::app()->user->name, CLogger::LEVEL_WARNING, 'blacklist');
            $this->blacklist = 1;
            $this->to_refurbish = 0;
        } else {
            $this->blacklist = 0;
        }

        $device = PriceList::model()->getByGifName($gif_data->respuesta->name);

        return $device;
    }

    /**
     * Setea los campos de la compra despues de tener el carrier_id
     */
    public function setPriceDataAtBuy() {
        $this->setPriceData();

        $this->purchase_price = $this->calculatePrice();
    }

    /**
     * Setea todos los campos que dependen de carrier_id
     */
    private function setPriceData() {
        if ($this->carrier_id !== null) {
            // Setea el nombre de operador
            $this->carrier_name = Carrier::model()->findByPk($this->carrier_id)->name;

            // Setea el tipo de precio
            if ($this->carrier_name == 'Liberado') {
                $this->price_type = 'unlocked_price';
            } else {
                $this->price_type = 'locked_price';
            }

            $pricelist = PriceList::model()->getDevice(array('brand' => $this->brand, 'model' => $this->model));
            // Setea pricelist_log
            $this->pricelist_log = CJSON::encode($pricelist->getAttributes());
            // Setea pricelist_id
            $this->price_list_id = $pricelist->id;

            // Actualiza el diccionario GIF
            $gif_data = CJSON::decode($this->gif_response_json, false);
            GifDictionary::model()->incrementQuantity($gif_data->respuesta->name, $this->brand, $this->model);
        } else {
            throw new Exception(Yii::t('app', 'carrier_id es nulo. No se pueden setear los datos del precio'), 1);
        }
    }

    /**
     * Calcula el precio con los datos actuales
     * @return mixed boolean, float
     */
    public function calculatePrice() {
        if ($this->price_type == null) {
            // Si no se seteo el price_type no se puede definir el precio
            return false;
        }

        $price_log_obj = CJSON::decode($this->pricelist_log, false);

        if ($this->compareLoggedAndActualDevice()) {
            // Devuelve el precio de lo que ya tenia en el log
            return $this->getLoggedPrice($this->price_type);
        }

        $pricelist = PriceList::model()->getDevice(array('brand' => $this->brand, 'model' => $this->model));

        return $pricelist->$price_type;
    }

    /**
     * Compara el dispositivo en el log con los datos actuales en brand y model
     * @return boolean
     */
    public function compareLoggedAndActualDevice() {
        if (!strlen(trim($this->pricelist_log))) {
            return false;
        }

        $price_log_obj = CJSON::decode($this->pricelist_log, false);

        if ($this->brand != $price_log_obj->brand) {
            return false;
        }

        if ($this->model != $price_log_obj->model) {
            return false;
        }

        return true;
    }

    /**
     * Devuelve el seller dependiendo si es compra masiva o minorista
     * @return mixed Seller AR o Company AR
     */
    public function getSeller() {
        if ($this->comprobante_tipo == self::COMPROBANTE_TIPO_COMPRA) {
            $seller_data = $this->seller->getAttributes();
            $seller_data['identification'] = $seller_data['dni'];
        }

        if ($this->comprobante_tipo == self::COMPROBANTE_TIPO_COMPRA_MASIVA) {
            $seller_data = $this->company->getAttributes();
            $seller_data['identification'] = $seller_data['cuit'];
        }

        if ($this->comprobante_tipo == self::COMPROBANTE_TIPO_NOTA_DE_CREDITO) {
            $seller_data = $this->company->getAttributes();
            $seller_data['identification'] = $seller_data['cuit'];
        }

        return $seller_data;
    }

    /**
     * Devuelve el seller dependiendo si es compra masiva o minorista
     * @return mixed Seller AR o Company AR
     */
    public function getSellerModel()
    {
        if ($this->comprobante_tipo == self::COMPROBANTE_TIPO_COMPRA) {
            return $this->seller;
        }

        if ($this->comprobante_tipo == self::COMPROBANTE_TIPO_COMPRA_MASIVA) {
            return $this->company;
        }

        if ($this->comprobante_tipo == self::COMPROBANTE_TIPO_NOTA_DE_CREDITO) {
            return $this->company;
        } 
    }

    public function setAfipData() {
        if (!$this->purchase_price) {
            throw new Exception("El equipo no tiene precio asignado", 1);
        }

        if (!$this->seller) {
            throw new Exception("El equipo no tiene cliente asignado", 1);
        }

        try {
            /**
             * Array con la respuesta de la AFIP con los siguienes items
             * ['contract_munber'] : integer
             * ['cae'] : integer
             * ['json_response'] : string : json raw del json que devuelve la afip con todos sus datos incluido el CAE
             *
             * @var array
             */
            $cae_array = Yii::app()->wsfe->getCaeParaContrato($this->purchase_price, $this->seller);
        } catch (Exception $e) {
            throw $e;
        }

        $this->contract_number = $cae_array['contract_number'];
        $this->cae = $cae_array['cae'];
        $this->cae_response_json = $cae_array['json_response'];
    }

    public function setSellingCode() {
        $brand = $this->brand_checked;
        $model = $this->model_checked;
        $carrier = Carrier::model()->findByPk($this->carrier_id_checked);

        $sellingCode = SellingCode::model()->findByAttributes(array('brand' => $brand, 'model' => $model));
        if (!empty($sellingCode)) {
            if ($this->to_refurbish) {
                switch ($carrier->name) {
                    case "Movistar":
                        $this->selling_code = $sellingCode->movistar_a;
                        break;
                    case "Personal":
                        $this->selling_code = $sellingCode->personal_a;
                        break;
                    case "Claro":
                        $this->selling_code = $sellingCode->claro_a;
                        break;
                    case "Liberado":
                        $this->selling_code = $sellingCode->liberado_a;
                        break;
                }
            } else {
                $this->selling_code = $sellingCode->bad_irreparable;
            }
        } else {
            $this->selling_code = null;
        }
    }

}
