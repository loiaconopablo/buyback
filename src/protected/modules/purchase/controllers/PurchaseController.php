<?php

class PurchaseController extends Controller
{
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
}
