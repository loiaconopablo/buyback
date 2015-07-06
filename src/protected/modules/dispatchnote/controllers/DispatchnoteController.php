<?php

class DispatchnoteController extends Controller
{
    /**
     * Muestra la nota de envio segun quien y cuando la este solicitando
     * @param  integer  $id       DispatchNote.id
     * @param  boolean $receiving True: si la nota se puede recibir
     */
    public function actionView($id, $receiving = false) 
    {
        $dispatch_note = DispatchNote::model()->findByPk($id);

        if (Yii::app()->request->isPostRequest) {
            // Se marca la nota de envio como recibida
            
            $purchases_array = array();

            if (isset($_POST['dispatch_selected'])) {
                $purchases_array = $_POST['dispatch_selected'];
            }

            try {
                // Cambia el estado de Dispatchote y todos sus Purchase
                $dispatch_note->receive($purchases_array);
                // Redirecciona a el listado de notas de envio por recibir
                $this->redirect(array('/headquarter/dispatchnote/expecting'));

            } catch(Exception $e) {
                // Setea el error para mostrar
                Yii::app()->user->setFlash('error', $e->getMessage());
                // Vuelve a la url que lo llamó
                $this->redirect(Yii::app()->request->urlReferrer);
            }
        }


        $criteria = new CDbCriteria;
        $criteria->compare('last_dispatch_note_id', $id);

        $purchasesDataProvider = new CActiveDataProvider(
            new Purchase, array(
                'criteria' => $criteria,
                'Pagination' => array(
                    'PageSize' => 5000
                )
            )
        );

        $view_data = array(
            'dispatch_note' => $dispatch_note,
            //'purchasesDataProvider' => $purchasesDataProvider,
            'model' => new Purchase,
        );

        if (Yii::app()->request->isAjaxRequest) {
            if ($receiving) {
                $this->renderPartial('./receiving.view', $view_data);
            } else {
                $this->renderPartial('./view.view', $view_data);
            }
        } else {
            if ($receiving) {
                $this->render('./receiving.view', $view_data);
            } else {
                $this->render('./view.view', $view_data);
            }
        }

    }

   /**
    * Genera la nota de envío por triplicado
    * @param  integer $id DispatchNote.id
    */
    public function actionGeneratePdf($id) 
    {
        $dispatch_note = DispatchNote::model()->findByPk($id);

        $purchases = Purchase::model()->findAllByAttributes(array('last_dispatch_note_id' => $id));

        // $company_from = Company::model()->findByPk($dispatch_note->company_id);

        $from = PointOfSale::model()->findByPk($dispatch_note->source_id);

        $to = PointOfSale::model()->findByPk($dispatch_note->destination_id);

        $html2pdf = Yii::app()->ePdf->HTML2PDF('P');
        $html2pdf->WriteHTML(
            $this->renderPartial(
                'dispatchnote_pdf_wrap',
                array(
                'dispatch_note' => $dispatch_note,
                ), true
            )
        );

        $html2pdf->Output();
    }

    /**
     * Marca la nota de envío y sus copras como enviadas
     * @param  [integer] $id DispatchNote.id
     */
    public function actionSetAsSent($id) 
    {
        $dispatch_note = DispatchNote::model()->findByPk($id);

        header('Content-Type: application/json');

        try {
            // Marca la nota de envío y sus compras como enviadas
            $dispatch_note->setAsSent();

        } catch (Exception $e) {
            // Ocurrió un error
            $response['status'] = 0;
            $response['errors'] = $e->getMessage();
            die(CJSON::encode($response));     
        }
    
        // No ocurrió ningún error
        $response['status'] = 1;
        $response['message'] = 'Nota de envío marcado como enviado';
        die(CJSON::encode($response));

    }

    /**
     * Cancela la nota de envío y todas sus compras
     * @param  integer $id DispatchNote.id
     */
    public function actionCancel($id) 
    {
        try {
            DispatchNote::model()->findByPk($id)->cancel();
            // No ocurrió ningún error
            $response['status'] = 1;
            $response['message'] = 'Nota de envío anulada';
            die(CJSON::encode($response));

        } catch (Exception $e) {
            // Ocurrió un error
            $response['status'] = 0;
            $response['errors'] = $e->getMessage();
            die(CJSON::encode($response));     

        }
    }
}