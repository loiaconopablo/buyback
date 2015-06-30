<?php

Yii::import('application.models._base.BaseDispatchNote');

class DispatchNote extends BaseDispatchNote
{
    const PENDING_TO_SEND = 20;
    const SENT = 30;
    const CANCELLED = 40;
    const PARTIALLY_RECEIVED = 50;
    const RECEIVED = 60;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * relations
     */
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

        //TODO: estas relaciones van a volar porque los campos no van a existir mas en Purchase
        //'dispatch_note_to_owner'   => array(self::HAS_MANY, 'Purchase', 'dispatch_note_to_owner_id'),

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
            'user_update_id' => Yii::t('app', 'User|Users', 1),
            'user_create_id' => Yii::t('app', 'Vendedor'),
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
        $criteria->condition = 'created_at >= :from AND created_at <= :to';
        $criteria->params = Helper::getDateFilterParams();

         /*
        Condiciones para los filstros de la tabla
         */
        $criteria->compare('dispatch_note_number', $this->dispatch_note_number, true);
        $criteria->compare('source_id', $this->source_id, true);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('user_create_id', $this->user_create_id, true);


        return new CActiveDataProvider(
            $this,
            array(
            'criteria' => $criteria,
            )
        );
    }

    /**
     * ADMIN DataProvider
     */
    public function admin()
    {
        $criteria = $this->search()->getCriteria();

        if (Yii::app()->user->checkAccess('retail')) {
            //=====================================//
            //  CABECERA  y PUNTO DE VENTA SIMPLE  //
            //=====================================//

            $criteria->compare('source_id', Yii::app()->user->point_of_sale_id);
            $criteria->compare('status', self::PENDING_TO_SEND);

        }

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
    public function expecting()
    {
        $criteria = $this->search()->getCriteria();

        if (Yii::app()->user->is_headquarter) {
            //============//
            //  CABECERA  //
            //============//
            $criteria->compare('destination_id', Yii::app()->user->point_of_sale_id);
            $criteria->addInCondition('status', array(self::PENDING_TO_SEND, self::SENT, self::PARTIALLY_RECEIVED));

        }

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
    public function historyOwn()
    {
        $criteria = $this->search()->getCriteria();

        if (Yii::app()->user->checkAccess('retail')) {
            //=====================================//
            //  CABECERA  y PUNTO DE VENTA SIMPLE  //
            //=====================================//
            $criteria->compare('source_id', Yii::app()->user->point_of_sale_id);
            $criteria->addNotInCondition('status', array(self::PENDING_TO_SEND));

        }

        return new CActiveDataProvider(
            $this,
            array(
            'criteria' => $criteria,
            )
        );
    }

    /**
     * HISTORY OTHERS DataProvider
     */
    public function historyOthers()
    {
        $criteria = $this->search()->getCriteria();

        if (Yii::app()->user->is_headquarter) {
            //=============//
            //  CABECERA   //
            //=============//
            $criteria->compare('destination_id', Yii::app()->user->point_of_sale_id);
            $criteria->addNotInCondition('status', array(self::PENDING_TO_SEND, self::SENT));

        }

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

            if ($this->save()) {
                //Actualiza el estado de las compras
                $criteria = new CDbCriteria;
                $criteria->addInCondition('id', $purchases);
                $purchase_model = Purchase::model()->findAll($criteria);

                foreach ($purchase_model as $purchase) {
                    $purchase->last_dispatch_note_id = $this->id;
                    $purchase->last_source_id = Yii::app()->user->point_of_sale_id;
                    $purchase->last_destination_id = Yii::app()->user->headquarter_id;
                    $purchase->setStatus(Status::PENDING_TO_SEND, $this->id);
                }

                return $this->id;

            } else {
                die(var_dump($this->getErrors()));
            }
        }

        return null;
    }

    /**
     *    Marca el remito como ENVIADO A LA CABECERA
     */
    public function setAsSent()
    {
        // Esto creo que no va mas y todos son iguales 17-02-2015

        // if (Yii::app()->user->is_headquarter) {
        //  // Si el remito lo esta despachando una cabecera lo esta enviando a BGH
        //  $this->status = self::SENT_TO_OWNER;
        //  $purchase_status = Status::REMOVED_FROM_HEADQUARTER;

        // } else {
        //  // Si el remito lo esta despachando un punto de venta comun lo esta enviando a su cabecera
        //  $this->status = self::SENT_TO_HEADQUARTER;
        //  $purchase_status = Status::SENT_TO_HEADQUARTER;

        // }

        $this->status = self::SENT;
        $this->sent_at = new CDbExpression('UTC_TIMESTAMP()');

        if ($this->save()) {
            foreach ($this->purchases as $purchase) {
                $purchase->setStatus(Status::SENT, $this->id);
            }
        } else {
            return false;
        }

        return true;
        //$purchases = Purchase::model()->findAllByAttributes(array('dispatch_note_to_headquarter_id' => $id));

    }

    /**
     * CREO QUE ESTO NO VA MAS 17-02-2015
     */
    // public function setAsReceivedInHeadquarter()
    // {
    //  $this->status = self::RECEIVED_IN_HEADQUARTER;
    //  $purchase_status = Status::RECEIVED_IN_HEADQUARTER;

    //  if ($this->save()) {
    //      foreach ($this->purchase_to_headquarter as $purchase) {
    //          $purchase->setStatus($purchase_status);
    //      }
    //  } else {
    //      return false;
    //  }

    //  return true;
    // }

    /**
     *
     */
    // public function getDestinationId()
    // {
    //  // TODO: Cuando se rediseñe lo de las cabeceras esta funcion no deberia existir mas
    //  // Siempre el destination deberia ser la cabecera
    //  if (Yii::app()->user->is_headquarter) {
    //      $company = Company::model()->findAllByAttributes(array('is_owner' => 1));
    //      return $company[0]->id;
    //  } else {
    //      return Yii::app()->user->headquarter_id;
    //  }
    // }

    public static function getRowClass($status)
    {
        if ($status == self::PENDING_TO_SEND) {
            return 'pending';
        }

        if ($status == self::RECEIVED) {
            return 'pending';
        }

        if ($status == self::PARTIALLY_RECEIVED) {
            return 'partially-recived';
        }

        if ($status == self::CANCELLED) {
            return 'cancelled';
        }

        return 'in-transit';
    }

    public static function availableToReception($status)
    {
        // Si me lo enviarn lo puedo recibir
        if ($status == self::SENT) {
            return true;
        }
        // Si habia quedado parcialmente recibido lo puedo recibir
        if ($status == self::PARTIALLY_RECEIVED) {
            return true;
        }
        // En cualquier otro caso no lo puedo recibir
        return false;
    }

    public function cancel()
    {
        $this->status = self::CANCELLED;
        $this->finished_at = new CDbExpression('UTC_TIMESTAMP()');

        if ($this->save()) {
            foreach ($this->purchases as $purchase) {
                if ($purchase->current_status_id != Status::CANCELLED) {
                    $purchase->setStatus(Status::PENDING);
                }
            }
        } else {
            return false;
        }

        return true;
    }

    /**
     * recibe un remito
     */
    public function receive(array $purchases)
    {
        $purchases_cancelled = 0;
        $purchases_received = 0;
        $purchases_pending_to_be_received = 0;

        // si no hay nada marcado no hace nada
        if (!count($purchases)) {
            return false;
        }

        foreach ($this->purchases as $purchase) {
            if ($purchase->current_status_id != Status::CANCELLED) {
                if (in_array($purchase->id, $purchases)) {
                    // La compra esta tildada como recibida cambia su estado a recibida y la ultima locacion es el lugar del usuario
                    $purchase->last_location_id = Yii::app()->user->point_of_sale_id;
                    $purchase->setStatus(Status::RECEIVED, $this->id);
                    $purchases_received++;

                } else {
                    if ($purchase->current_status_id != Status::RECEIVED) {
                        // Si todavia no esta recibido
                        $purchase->setStatus(Status::PENDING_TO_BE_RECEIVED, $this->id);
                        $purchases_pending_to_be_received++;
                    }

                }

            } else {
                $purchases_cancelled++;

            }
        }

        if ($purchases_pending_to_be_received) {
            $this->status = self::PARTIALLY_RECEIVED;

        } else {
            // Esta completamente recibido y ya no tiene compras pendientes
            $this->status = self::RECEIVED;
            $this->finished_at = new CDbExpression('UTC_TIMESTAMP()');

        }

        if ($this->save()) {
            return true;
        }
    }

    /**
     * Referencias de colores
     */
    public static function references()
    {
        $references = array(
        array('label' => Yii::t('app', 'REFERENCIAS'), 'icon' => 'th-large', 'url' => '#', 'active' => true),
        array('label' => Yii::t('app', 'En punto de venta'), 'icon' => 'th-large', 'url' => '#', 'htmlOptions' => array('class' => 'pending reference')),
        array('label' => Yii::t('app', 'Parcialmente recibido'), 'icon' => 'th-large', 'url' => '#', 'htmlOptions' => array('class' => 'partially-recived reference')),
        array('label' => Yii::t('app', 'En transito'), 'icon' => 'th-large', 'url' => '#', 'htmlOptions' => array('class' => 'reference in-transit')),
        array('label' => Yii::t('app', 'Anulada'), 'icon' => 'th-large', 'url' => '#', 'htmlOptions' => array('class' => 'cancelled reference')),
        );

        return $references;
    }

    public function getPending()
    {
        $criteria = $this->admin()->getCriteria();

        return $this->findAll($criteria);
    }

    public function getExpecting()
    {
        $criteria = $this->expecting()->getCriteria();

        return $this->findAll($criteria);
    }

    public function getOwnHistory()
    {
        $criteria = $this->historyOwn()->getCriteria();

        return $this->findAll($criteria);
    }

    public function getOthersHistory()
    {
        $criteria = $this->historyOthers()->getCriteria();

        return $this->findAll($criteria);
    }
}
