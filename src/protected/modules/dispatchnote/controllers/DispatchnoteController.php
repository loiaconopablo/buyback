<?php

class DispatchnoteController extends Controller
{
    /**
     * Muestra la nota de envio para ver el detalle e imprimirla
     * @param  integer  $id       DispatchNote.id
     */
    public function actionView($id) 
    {
        $this->layout = '//layouts/column1.view';
        
        $dispatch_note = DispatchNote::model()->findByPk($id);

        $view_data = array(
            'dispatch_note' => $dispatch_note,
        );

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('view', $view_data);
        } else {
            $this->render('view', $view_data);
        }

    }

    /**
     * Muestra la nota de envio para ser recibida
     * @param  integer  $id       DispatchNote.id
     */
    public function actionReceiving($id) 
    {
        $this->layout = '//layouts/column1.view';
        
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
                $this->redirect(array('/dispatchnote/list/expecting'));

            } catch(Exception $e) {
                // Setea el error para mostrar
                Yii::app()->user->setFlash('error', $e->getMessage());
                // Vuelve a la url que lo llamó
                $this->redirect(Yii::app()->request->urlReferrer);
            }
        }

        $view_data = array(
            'dispatch_note' => $dispatch_note,
        );

        $this->render('receiving', $view_data);

    }

   /**
    * Genera la nota de envío por triplicado
    * @param  integer $id DispatchNote.id
    */
    public function actionGeneratePdf($id) 
    {
        $dispatch_note = DispatchNote::model()->findByPk($id);

        $purchases = Purchase::model()->findAllByAttributes(array('last_dispatch_note_id' => $id));

        $html2pdf = Yii::app()->ePdf->HTML2PDF('P');
        $html2pdf->WriteHTML(
            $this->renderPartial(
                'dispatchnote_pdf_wrap',
                array(
                'dispatch_note' => $dispatch_note,
                ), true
            )
        );

        $html2pdf->Output(Yii::t('app', 'dispatch_note_') . $dispatch_note->dispatch_note_number . '.pdf');
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
