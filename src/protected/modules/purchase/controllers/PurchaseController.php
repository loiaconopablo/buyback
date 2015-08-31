<?php

class PurchaseController extends Controller
{
    /**
    * @return array action filters
    */
    public function filters()
    {
            return array(
                    'accessControl', // perform access control for CRUD operations
            );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('view', 'dispatch'),
                'expression' => "Yii::app()->user->checkAccess('retail')",
            ),
             array(
                'allow',
                'actions' => array('view'),
                'expression' => "Yii::app()->user->checkAccess('company_admin')",
            ),
             array(
                'allow',
                'actions' => array('ownerview', 'dispatch', 'cancel'),
                'expression' => "Yii::app()->user->checkAccess('admin')",
            ),
              array(
                'allow',
                'actions' => array('GetmodelsJSON'),
                'users'=>array('*'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

   /**
    * Solo renderiza la vista de un purchase sin layout
    * porque va dentro de un modal
    *
    * @param  integer $id Purchase.id
    */
    public function actionView($id)
    {
        $this->renderPartial('view', array('model' => Purchase::model()->findByPk($id)));
    }

    /**
     * Similar a actionView pero muestra muchos mas detalles
     * en el historial
     *
     * @param  integer $id Purchse.id
     */
    public function actionOwnerView($id)
    {
        $this->renderPartial('owner-view', array('model' => Purchase::model()->findByPk($id)));
    }


    /**
     * Lista los equipos (purchase) listados en la tabla de admin
     * Tanto los de retail como los de headquarter
     * Y los despacha en una nueva nota de envio (dispatchnote)
     *
     * @author Richard Gribnerg <rggrinberg@gmail.com>
     */
    public function actionDispatch()
    {
        $this->layout = '//layouts/column1.view';
        
        $dispatch_note_model = new DispatchNote;

        /**
         * Toma los id de purchases seleccionados que estan en la cookie
         * @var array
         */
        $purchases = explode(',', Yii::app()->request->cookies['checkedItems']->value);

        
        // Si cumple la condición es porque viene del submit del form para confirmar y despachar
        // los equipos (purchase) en una nota de envío (dispatchnote)      
        if (isset($_POST['DispatchNote'])) {
            $dispatch_note_model->setAttributes($_POST['DispatchNote']);
            $dispatch_note_model->user_sent_id = Yii::app()->user->id;
            try {
                $dispatch_note_id = $dispatch_note_model->create($purchases);
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', $e->getMessage());
            }

            if (isset($dispatch_note_id)) {
                $this->redirect(array('/dispatchnote/dispatchnote/view', 'id' => $dispatch_note_id));
            }
        }
        
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $purchases);

        $model = new Purchase;

        $dataProvider = new CActiveDataProvider(
            new Purchase,
            array(
            'criteria' => $criteria,
            )
        );

        $this->render(
            'dispatch',
            array(
            'dataProvider' => $dataProvider,
            'model' => $model,
            'dispatch_note_model' => $dispatch_note_model,
            )
        );
    }


    /**
     * Devuelve un json con los modelos de la marca seleccionada
     * @param  string $brand marca de equipo
     */
    public function actionGetmodelsJSON($brand)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $models = PriceList::model()->findAllByAttributes(array('brand' => $brand), array('order'=>'model'));

            header('Content-type: application/json');
      
            echo CJSON::encode($models);
            Yii::app()->end();
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    /**
     * Anula una compra generando su respectiva nota de credito asociada
     * @param  int $id Purchase.id
     */
    public function actionCancel($id)
    {
        // La compra a anular
        $associate_purchase = Purchase::model()->findByPk($id);
        
        // El contrato de anulación
        $new_purchase = new Purchase;

        // Duplica los datos sin id
        $data = $associate_purchase->attributes;
        unset($data['id']);
        $new_purchase->setAttributes($data, false);

        // Inicia la transacción de DisptchNote
        $transaction = Yii::app()->getDb()->beginTransaction();

  

        // Setea los últimos campos de purchase
        $new_purchase->setAttributes(array(
            'point_of_sale_id' => Yii::app()->user->point_of_sale_id,
            'company_id' => Yii::app()->user->company_id,
            'headquarter_id' => Yii::app()->user->headquarter_id,
            'user_ip' => Yii::app()->request->userHostAddress,
            'comprobante_tipo' => Purchase::COMPROBANTE_TIPO_NOTA_DE_CREDITO,
            'associate_row' => $associate_purchase->id,
            'purchase_price' => -($new_purchase->purchase_price),
        ));

        try {
            $new_purchase->setAfipData();
        } catch (Excaption $e) {

            $transaction->rollback;

            $response['status'] = 0;
            $response['errors'] = $e->getMessage();
            die(CJSON::encode($response));
        }

        if ($new_purchase->save()) {
            
            $new_purchase->refresh();
            $new_purchase->setStatus(Status::PENDING);

            // Actualiza la compra anulada
            $associate_purchase->associate_row = $new_purchase->id;
            $associate_purchase->setStatus(Status::CANCELLED);

            $transaction->commit();

            // Genera la respuesta para el javascript
            $response['status'] = 1;
            $response['purchase_id'] = $new_purchase->id;
            $response['message'] = 'Cancelación de compra generada.';
            die(CJSON::encode($response));

        } else {

            $transaction->rollback;

            $response['status'] = 0;
            $response['errors'] = $new_purchase->getErrors();
            die(CJSON::encode($response));
        }
    }
}
