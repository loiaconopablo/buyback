<?php

Yii::import('application.models._base.BaseDispatchNote');

class DispatchNote extends BaseDispatchNote
{
    const PENDING_TO_SEND = 20;
    const SENT = 30;
    const CANCELLED = 40;
    const PARTIALLY_RECEIVED = 50;
    const RECEIVED = 60;
    /**
     * Si se agrega o cambia algo reflejarlo en widget de las referencias components/DispatchnoteReferences.php
     */

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function representingColumn() 
    {
        return 'dispatch_note_number';
    }


    public function relations()
    {
        return array(
        'purchases' => array(self::HAS_MANY, 'Purchase', 'last_dispatch_note_id'),
        'purchase_statuses' => array(self::HAS_MANY, 'PurchaseStatus', 'dispatch_note_id'),

        'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
        'point_of_sale' => array(self::BELONGS_TO, 'PointOfSale', 'source_id'),
        'destination' => array(self::BELONGS_TO, 'PointOfSale', 'destination_id'),
        'user' => array(self::BELONGS_TO, 'User', 'user_create_id'),
        'user_log' => array(self::BELONGS_TO, 'User', 'user_update_id'),
        );
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Dispatch note|Dispatch notes', $n);
    }

    public function attributeLabels()
    {
        return CMap::mergeArray(
            parent::attributeLabels(),
            array(
            'user_update_id' => Yii::t('app', 'Usuario'),
            'user_create_id' => Yii::t('app', 'Usuario'),
            'comment' => Yii::t('app', 'Comentario'),
            'created_at' => Yii::t('app', 'Fecha'),
            )
        );
    }

    /**
     * Extiende de la clase Base
     */
    public function search()
    {
        $criteria = parent::search()->getCriteria();

         /*
        Condiciones para filtrar entre fechas
         */
        $params_created = Helper::getDateFilterParams('created_at');
        $criteria->addBetweenCondition('t.created_at',  $params_created[':from'], $params_created[':to']);


        /**
         * Filtra por estados si esta seteada la cookie
         */
        $checkedItemsArray = array();

        if (isset(Yii::app()->request->cookies['checkedDispatchnoteStatuses'])) {
            $checkedItemsArray = explode(',', Yii::app()->request->cookies['checkedDispatchnoteStatuses']->value);

        }

        $criteria->addInCondition('status', $checkedItemsArray);

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
     * PENDING DataProvider
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
    /**
     * Devuelve las notas de envio confeccionadas en este punto de venta y que todavia no se enviaron
     * @param  Criteria $criteria [description]
     * @return Dataprovider          [description]
     */
    public function pendingSearch($criteria)
    {
        $criteria->compare('source_id', Yii::app()->user->point_of_sale_id);
        $criteria->compare('status', self::PENDING_TO_SEND);


        return new CActiveDataProvider(
            $this,
            array(
            'criteria' => $criteria,
            )
        );
    }


    /**
     *  EXPECTING
     */
    public function expecting()
    {
        $criteria = $this->search()->getCriteria();

        return $this->expectingSearch($criteria);
    }

    public function expectingReferences()
    {
        $criteria = parent::search()->getCriteria();

        return $this->expectingSearch($criteria);
    }

    /**
     * Devuelve las que se pueden recibir o deberian enviarse para ser recibidas
     * @return DataProvider
     */
    public function expectingSearch($criteria)
    {
              
        $criteria->compare('destination_id', Yii::app()->user->point_of_sale_id);
        $criteria->addInCondition('status', array(self::PENDING_TO_SEND, self::SENT, self::PARTIALLY_RECEIVED));


        return new CActiveDataProvider(
            $this,
            array(
            'criteria' => $criteria,
            )
        );
    }

    /**
     * HISTORY OWN DataProvider
     */
    public function history()
    {
        $criteria = $this->search()->getCriteria();

        return $this->historySearch($criteria);
    }

    public function historyReference()
    {
        $criteria = parent::search()->getCriteria();

       return $this->historySearch($criteria);
    }

    public function historySearch($criteria)
    {
        $criteria->addCondition('source_id = :source_id OR destination_id = :destination_id');
        $criteria->params = CMap::mergeArray($criteria->params, array(
            ':source_id' => Yii::app()->user->point_of_sale_id,
            ':destination_id' => Yii::app()->user->point_of_sale_id
        ));

        return new CActiveDataProvider(
            $this,
            array(
            'criteria' => $criteria,
            )
        );
    }


    /**
     * Crea una nueva nota de envio
     * @param  array  $purchases Array con los id de purchase que entran en la nota de envio
     * @return integer  Ide de la nota de envio creada
     */
    public function create(array $purchases)
    {
        if (count($purchases)) {

            $this->company_id = Yii::app()->user->company_id;
            $this->source_id = Yii::app()->user->point_of_sale_id;
            $this->dispatch_note_number = Company::model()->findByPk(Yii::app()->user->company_id)->getDispatchNoteNumber();

            $this->destination_id = Yii::app()->user->headquarter_id;

            $this->status = self::PENDING_TO_SEND;

            // Inicia la transacción de DisptchNote
            $transaction = $this->dbConnection->beginTransaction();

            try {
                $this->save();
                //Actualiza el estado de las compras
                $criteria = new CDbCriteria;
                $criteria->addInCondition('id', $purchases);

                $purchase_model = new Purchase;

                $purchases = $purchase_model->findAll($criteria);

                try {
                    foreach ($purchases as $purchase) {
                        // Actualiza el estado de Purchase y crea un registro PurchaseStatus
                        $this->setPurchaseStatus($purchase);
                    }
                } catch (Exception $e) {
                    throw $e;
                }

                // Si no tiró ninguna exepción todos los Purchase se actualizaron correctamente
                // Ejecuta la transacción
                $transaction->commit();

                return $this->id;
            } catch (Exception $e) {
                // Hubo una excepción y no se ejecutan los update e insert
                $transaction->rollback();
                throw $e;
            }
        }

        return null;
    }

   /**
    * Marca la nota de envío y sus compras como enviadas
    */
    public function setAsSent()
    {

        $this->status = self::SENT;
        $this->sent_at = new CDbExpression('UTC_TIMESTAMP()');

        // Inicio la transacción para poder hacer rollback si algún model->save() dispara una excepción
        $transaction = Yii::app()->db->beginTransaction();

        try {
            if ($this->save()) {
                foreach ($this->purchases as $purchase) {
                    $purchase->setStatus(Status::SENT, $this->id);
                }
            } else {
                throw new Exception("Error actualizando el estado de la nota de envío: ID = " . $this->id, 1);
            }
        } catch (Exception $e) {
            // Vuelve atras los registros modificados porque ocurrió un error
            $transaction->rollback();
            throw $e;
        }

        // Ejecuta las modificacione sen la base de datos porque no hubieron errores
        $transaction->commit();

    }

    public static function availableToReception($dispatchnote)
    {
        // Si no se la enviaron al usuario no la puede recibir
        if (Yii::app()->user->point_of_sale_id != $dispatchnote->destination_id) {
            return false;
        }
        // Si me lo enviarn lo puedo recibir
        if ($dispatchnote->status == self::SENT) {
            return true;
        }
        // Si habia quedado parcialmente recibido lo puedo recibir
        if ($dispatchnote->status == self::PARTIALLY_RECEIVED) {
            return true;
        }
        // En cualquier otro caso no lo puedo recibir
        return false;
    }

    /**
     * Marca la nota de envío y sus compras como canceladas
     */
    public function cancel()
    {
        $this->status = self::CANCELLED;
        $this->finished_at = new CDbExpression('UTC_TIMESTAMP()');

        // Inicio la transacción para poder hacer rollback si algún model->save() dispara una excepción
        $transaction = Yii::app()->db->beginTransaction();

        try {
            if ($this->save()) {
                foreach ($this->purchases as $purchase) {
                    if ($purchase->current_status_id != Status::CANCELLED) {
                        $purchase->setStatus(Status::PENDING);
                    }
                }
            } else {
                throw new Exception("Error actualizando el estado de la nota de envío: ID = " . $this->id, 1);
            }
        } catch (Exception $e) {
            // Vuelve atras los registros modificados porque ocurrió un error
            $transaction->rollback();
            throw $e;
        }

        // Ejecuta las modificacione sen la base de datos porque no hubieron errores
        $transaction->commit();
    }

    /**
     * Marca la nota de envio y todos los equipos seleccionados de esta como recibidos
     * @param  array  $purchases colección de Purchase.id
     */
    public function receive(array $purchases_to_be_recived)
    {
        $purchases_cancelled = 0;
        $purchases_received = 0;
        $purchases_pending_to_be_received = 0;

        // si no hay nada marcado no hace nada
        if (!count($purchases_to_be_recived)) {
            throw new Exception("Seleccione al menos un equipo a ser recibido", 1);
        }

        // Inicio la transacción para poder hacer rollback si algún model->save() dispara una excepción
        $transaction = Yii::app()->db->beginTransaction();

        try {

            foreach ($this->purchases as $purchase) {

                if ($purchase->current_status_id != Status::CANCELLED) {

                    if (in_array($purchase->id, $purchases_to_be_recived)) {

                        try {
                            /*
                            La compra esta tildada como recibida 
                            Se cambia su estado a recibida y la última locación por la locación del usuario
                             */
                            $purchase->last_location_id = Yii::app()->user->point_of_sale_id;
                            $purchase->setStatus(Status::RECEIVED, $this->id);

                            // Suma uno a recibidos
                            $purchases_received++;

                        } catch (Exception $e) {
                            throw $e;
                        }

                    } else {

                        if ($purchase->current_status_id != Status::RECEIVED) {
                            try {
                                // La compra no esta tildada como recibida
                                // No está recibida actualmente
                                // No esta cancelada
                                // Se marca como pendiente a ser recibida
                                $purchase->setStatus(Status::PENDING_TO_BE_RECEIVED, $this->id);
                                // Suma uno a los pendientes
                                $purchases_pending_to_be_received++;

                            } catch (Exception $e) {
                                throw $e;
                            }
                            
                        }

                    }

                } else {
                    // Suma una cancelada
                    $purchases_cancelled++;

                }
            }
        } catch (Exception $e) {
            // Restaura los cambios porque hubo un error
            $transaction->rollback();

            throw $e;
        }

        if ($purchases_pending_to_be_received && $purchases_received) {
            // Si hay algún pendiente y almenos un recibido
            // la nota de envío se marca como parcialmente recibida
            $this->status = self::PARTIALLY_RECEIVED;

        } elseif ($purchases_received) {
            // Las compras estan recibido o cancelados
            // y ya no tiene compras pendientes
            $this->status = self::RECEIVED;
            $this->finished_at = new CDbExpression('UTC_TIMESTAMP()');
        }

        try {
            // Guarda el estado de la nota de envío
            $this->save();

        } catch (Exception $e) {
            // Restaura los cambios porque hubo un error
            $transaction->rollback();
            throw $e;
        }
    
        // No ocurrió ningún error y no se disparó ninguna excepción
        // Se ejecuta la transacción
        $transaction->commit();
    }

    /**
     * Actualiza el AR Purchase que se le pasa y crea un registro de PurchaseStatus
     * @param Purchase $purchase AR de Purchase
     */
    public function setPurchaseStatus($purchase)
    {
        $purchase->last_dispatch_note_id = $this->id;
        $purchase->last_source_id = Yii::app()->user->point_of_sale_id;
        $purchase->last_destination_id = Yii::app()->user->headquarter_id;

        try {
            // Actualiza el estado de Purchase y crea un registro en PurchaseStatus
            $purchase->setStatus(Status::PENDING_TO_SEND, $this->id);
        } catch(Exception $e) {
            // Si alguno no se puede guardar se hace rollback a todos los saves
            throw $e;
        }
    }

    /**
     * Devuelve un dataprovider con las purchases que integran la nota de envío
     * Se utiliza sobre todo para armar grillas y tablas
     * @return CActiveDataProvider Purchases que integran la nota de envío
     */
    public function purchasesDataProvider()
    {
        $purchase_statuses = PurchaseStatus::model()->findAllByAttributes(array("dispatch_note_id" => $this->id, "status_id" => Status::PENDING_TO_SEND));

        $purchases = array();

        foreach($purchase_statuses as $purchase_status) {
            array_push($purchases, $purchase_status->purchase);
        }

        $purchasesDataProvider = new CActiveDataProvider('PurchaseStatus');
        $purchasesDataProvider->setData($purchases);

        return $purchasesDataProvider;
    }

    /**
     * Devuelve el nombre de la constante de estado
     * @return string nombre le la constante de estado
     */
    public function getStatusName()
    {
        $reflection = new ReflectionClass(__CLASS__);
        $constants = $reflection->getConstants();

        return array_search($this->status, $constants);;
    }
}
