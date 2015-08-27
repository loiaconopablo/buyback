<?php

Yii::import('application.models._base.BasePurchase');

class Purchase extends BasePurchase
{
    const DEFAULT_PAID_PRICE = 0;

    const COMPROBANTE_TIPO_COMPRA = 'C';
    const COMPROBANTE_TIPO_NOTA_DE_CREDITO = 'NC';

    public $quantity;
    public $price_average;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function relations()
    {
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
        'price_list' => array(self::BELONGS_TO, 'PriceList', 'price_list_id'),
        'current_status' => array(self::BELONGS_TO, 'Status', 'current_status_id'),
        'user_log' => array(self::BELONGS_TO, 'User', 'user_update_id'),
        'associate_purchase' => array(self::BELONGS_TO, 'Purchase', 'associate_row'),
        );
    }

    public static function representingColumn() {
        return 'contract_number';
    }

    public function attributeLabels()
    {
        return CMap::mergeArray(
            parent::attributeLabels(),
            array(
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
            )
        );
    }

    public function rules()
    {
        return CMap::mergeArray(
            parent::rules(),
            array(
                array('', 'safe', 'on' => 'search'),
                array('imei_checked, peoplesoft_order', 'required', 'on' => 'checking'),
                array('contract_number', 'unique', 'on' => 'insert'),
            )
        );
    }

    public function searchReferences()
    {
        return parent::search();
    }

    public function search()
    {
        $criteria = parent::search()->getCriteria();

        $criteria->select = 't.*';
        
        $params_created = Helper::getDateFilterParams('created_at');
        $params_recived = Helper::getDateFilterParams('recived_at');
        $criteria->join = 'LEFT JOIN purchase_status AS ps ON t.id = ps.purchase_id';
        $criteria->addBetweenCondition('t.created_at',  $params_created[':from'], $params_created[':to']);
        $criteria->addBetweenCondition('ps.created_at',  $params_recived[':from'], $params_recived[':to']);
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
            $this,
            array(
                'criteria' => $criteria,
                'pagination'=>array(
                    'pageSize'=>20,
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
    public function admin()
    {

        $criteria = $this->search()->getCriteria();

        return $this->adminSearch($criteria);
    }
    
    public function adminReferences()
    {
        $criteria = parent::search()->getCriteria();

        return $this->adminSearch($criteria);
    }

    public function adminSearch($criteria)
    {
         /*
        Condiciones para mostrar solo los equipos que el usuario debe ver en esta lista
         */
        $criteria->compare('last_location_id', Yii::app()->user->point_of_sale_id);
        $criteria->addInCondition('current_status_id', array(Status::PENDING, Status::RECEIVED));

        return new CActiveDataProvider(
            $this,
            array(
            'criteria' => $criteria,
            )
        );
    }

    /**
     * Agrega condiciones al criterio de search para filtrar los equipos que estan en estado
     * RECEIVED o PENDING para en el point_of_sale_id del usuario de session
     * @author Richard Grinberg <rggrinberg@gmail.com>
     * @return CActiveDataProvider conjunto de reguistros que responden al criterio genenrado
     */
    public function company()
    {

        $criteria = $this->search()->getCriteria();

        return $this->companySearch($criteria);
    }
    
    public function companyReferences()
    {
        $criteria = parent::search()->getCriteria();

        return $this->companySearch($criteria);
    }

    public function companySearch($criteria)
    {
         /*
        Condiciones para mostrar solo los equipos que el usuario debe ver en esta lista
         */
        $criteria->compare('t.company_id', Yii::app()->user->company_id);

        return new CActiveDataProvider(
            $this,
            array(
            'criteria' => $criteria,
            )
        );
    }

    /**
     * Agrega condiciones al criterio de search para filtrar los equipos que estan en los estados
     * donde no se encuentra aún en la cabecera del Owner
     * @author Richard Grinberg <rggrinberg@gmail.com>
     * @return CActiveDataProvider conjunto de reguistros que responden al criterio genenrado
     */
    public function pending()
    {

        $criteria = $this->search()->getCriteria();

        return $this->pendingSearch($criteria);


    }

    public function pendingReferences()
    {
        $criteria = parent::search()->getCriteria();

        return $this->pendingSearch($criteria);
    }

    public function pendingSearch($criteria)
    {
        $criteria->addCondition('last_location_id != :user_point_of_sale');
        $criteria->params[ ':user_point_of_sale' ] = Yii::app()->user->point_of_sale_id;
        $criteria->order = 'created_at DESC';

        return new CActiveDataProvider(
            $this,
            array(
            'criteria' => $criteria,
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
    public function setStatus($status, $dispatch_note_id = 0, $comment = null)
    {
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
    public function setAsCancelled()
    {
        $this->setStatus(Status::CANCELLED, $this->last_dispatch_note_id);
    }

    /**
     * TODO: hacer que a este metodo se le pase el estado y sea generico
     * TODO: cambir nombre a setPurchasesStatus
     * Recibe un array de ids de purchase y les cambia el estado a IN_OBSERVATION
     * Guarda para cada purchase su estado y comentario en purchase_status
     * @param array  $purchase_ids array de purchases id
     * @param string $comment      comentario
     */
    public function setPurchasesInObservation($purchase_ids, $comment)
    {

        if (count($purchase_ids)) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $purchase_ids);
            $purchase_model = self::model()->findAll($criteria);

            foreach ($purchase_model as $purchase) {
                $purchase->setStatus(Status::IN_OBSERVATION, null, $comment);
            }

            return true;
        }

        return false;
    }

    /**
     * Devuelve el AR de PurchaseStatus con mayor id donde la compra tiene el estado RECEIVED
     * o null si no encuentra nada
     * @return timestamp la fecha del ultimo estado RECIVED
     */
    public function getLastRecivedDate()
    {
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
    public function getTotalPurchaseBetweenDates($from, $to)
    {
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('t.created_at',  $from, $to);
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
    public function getBrandQuantitiesBetweenDates($from, $to)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.brand, COUNT(t.id) AS "quantity"';
        $criteria->addBetweenCondition('t.created_at',  $from, $to);
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
    public function getBrandPriceAverageBetweenDates($from, $to)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.brand, AVG(t.purchase_price) AS "price_average"';
        $criteria->addBetweenCondition('t.created_at',  $from, $to);
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
    public function getWorkingPointsOfSaleBetweenDates($from, $to)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 't.brand, COUNT(t.id) AS "quantity"';
        $criteria->addBetweenCondition('t.created_at',  $from, $to);
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
    public function getLoggedPrice($price_type)
    {
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
    public function getGifRequestId()
    {
        $gif_response_json = CJSON::decode($this->gif_response_json);

        if (strlen(trim($this->gif_response_json))) {
            return $gif_response_json['respuesta']['id_request'];
        }
        
        return false;
    }

    /**
     * Chequea que el mismo cliente no intente vender el mismo imei 2 o más veces
     * @param  string $imei       IMEI del equipo
     * @param  integer $seller_dni DNI del cliente
     * @return bollean            [description]
     */
    public function checkIsDuplicate($imei, $seller_dni)
    {
        $criteria = new CDbCriteria;
        $criteria->addNotInCondition('current_status_id', array(Status::CANCELLED, Status::CANCELLATION));
        $criteria->compare('imei', $imei);
        $equipos = $this->findAll($criteria);


        if (count($equipos)) {
            foreach ($equipos as $equipo) {
                if ($equipo->seller->dni == $seller_dni) {
                    // El equipo ya fue vendido con ese DNI
                    return true;
                }
            }
        }

        // No existe el IMEI no es duplicado
        return false;
    }
}