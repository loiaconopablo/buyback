<?php

Yii::import('application.models._base.BasePurchase');

class Purchase extends BasePurchase
{
    const DEFAULT_PAID_PRICE = 0;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function relations()
    {
        return array(
        'purchase_statuses' => array(self::HAS_MANY, 'PurchaseStatus', 'purchase_id'),

        'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
        'point_of_sale' => array(self::BELONGS_TO, 'PointOfSale', 'point_of_sale_id'),
        'last_location' => array(self::BELONGS_TO, 'PointOfSale', 'last_location_id'),
        'headquarter' => array(self::BELONGS_TO, 'PointOfSale', 'headquarter_id'),
        'user' => array(self::BELONGS_TO, 'User', 'user_create_id'),
        'seller' => array(self::BELONGS_TO, 'Seller', 'seller_id'),
        'carrier' => array(self::BELONGS_TO, 'Carrier', 'carrier_id'),
        'price_list' => array(self::BELONGS_TO, 'PriceList', 'price_list_id'),
        'current_status' => array(self::BELONGS_TO, 'Status', 'current_status_id'),
        'user_log' => array(self::BELONGS_TO, 'User', 'user_update_id'),
        );
    }

    public function attributeLabels()
    {
        return CMap::mergeArray(
            parent::attributeLabels(),
            array(
            'user_update_id' => Yii::t('app', 'User|Users', 1),
            'user_create_id' => Yii::t('app', 'Usuario'),
            'user' => Yii::t('app', 'Seller|Sellers', 1),
            'created_at' => Yii::t('app', 'F. de compra'),
            )
        );
    }

    public function rules()
    {
        return CMap::mergeArray(
            parent::rules(),
            array(
            array('', 'safe', 'on' => 'search'),
            )
        );
    }

    public function search()
    {
        $criteria = parent::search()->getCriteria();

        /*
        Condiciones para filtrar entre fechas
         */
        $criteria->condition = 'created_at >= :from AND created_at <= :to';
        $criteria->params = Helper::getDateFilterParams();

        /*
        Condiciones para los filstros de la tabla
         */
        $criteria->compare('contract_number', $this->contract_number, true);
        $criteria->compare('brand', $this->brand, true);
        $criteria->compare('model', $this->model, true);
        $criteria->compare('purchase_price', $this->purchase_price, true);
        $criteria->compare('user_create_id', $this->user_create_id, true);
        $criteria->compare('point_of_sale_id', $this->point_of_sale_id, true);

        return new CActiveDataProvider(
            $this,
            array(
            'criteria' => $criteria,
            )
        );
    }

    /**
     * Agrega condiciones al criterio de search para filtrar los equipos que estan en estado
     * RECIVED o PENDING para en el point_of_sale_id del usuario de session
     * @author Richard Grinberg <rggrinberg@gmail.com>
     * @return CActiveDataProvider conjunto de reguistros que responden al criterio genenrado
     */
    public function admin()
    {
        /**
         * Criterio del metodo search
         * @var CCriteria
         */
        $criteria = $this->search()->getCriteria();

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
     * Agrega condiciones al crieria de search para filtrar los equipos IN_OBSERVATION
     * para el point_of_sale de user session
     * @author Richard Grinberg <rggrinberg@gmail.com>
     * @return CActiveDataProvider conjunto de reguistros que responden al criterio genenrado
     */
    public function inObservation()
    {
        /**
         * Criterio del metodo search
         * @var CCriteria
         */
        $criteria = $this->search()->getCriteria();

        $criteria->compare('last_location_id', Yii::app()->user->point_of_sale_id);
        $criteria->addInCondition('current_status_id', array(Status::IN_OBSERVATION));

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
        /**
         * Criterio del metodo search
         * @var CCriteria
         */
        $criteria = $this->search()->getCriteria();

        $criteria->addCondition('last_location_id != :user_point_of_sale');
        $criteria->params[ ':user_point_of_sale' ] = Yii::app()->user->point_of_sale_id;
        //$criteria->compare('last_location_id', Yii::app()->user->point_of_sale_id);
        //$criteria->addInCondition('current_status_id', array(Status::PENDING, Status::RECEIVED));

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

    // TODO: Revisar si este metodo no deberia er reemplazado por los que extienden el criteria de search
    // commented: 07-05-2015
    public function getRetailAdminPurchases()
    {
        $criteria = $this->admin()->getCriteria();

        return $this->findAll($criteria);
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
}