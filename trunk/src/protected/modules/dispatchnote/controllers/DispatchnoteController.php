<?php

class DispatchnoteController extends Controller
{
    /**
     * Muestra el Nota de envío
     */
    public function actionView($id, $receiving = false) 
    {
        $dispatch_note = DispatchNote::model()->findByPk($id);

        if (Yii::app()->request->isPostRequest) {

            $purchases_array = array();

            if (isset($_POST['dispatch_selected'])) {
                $purchases_array = $_POST['dispatch_selected'];
            }

            if ($dispatch_note->receive($purchases_array)) {
                $this->redirect(array('/headquarter/dispatchnote/expecting'));
            } else {
                Yii::app()->user->setFlash('receiving', 'Hubo un error recibiendo la Nota de envío');
                $this->redirect(Yii::app()->request->urlReferrer);
            }
        }

        $company_from = Company::model()->findByPk($dispatch_note->company_id);

        $from = PointOfSale::model()->findByPk($dispatch_note->source_id);

        $to = PointOfSale::model()->findByPk($dispatch_note->destination_id);

        $criteria = new CDbCriteria;
        $criteria->compare('last_dispatch_note_id', $id);

        $purchasesDataProvider = new CActiveDataProvider(
            new Purchase, array(
            'criteria' => $criteria,
            )
        );

        $view_data = array(
        'dispatch_note' => $dispatch_note,
        'purchasesDataProvider' => $purchasesDataProvider,
        'company_from' => $company_from,
        'from' => $from,
        'to' => $to,
        'model' => new Purchase,
        );

        if (Yii::app()->request->isAjaxRequest) {
            if ($receiving) {
                $this->renderPartial('view-receiving', $view_data);
            } else {
                $this->renderPartial('view', $view_data);
            }
        } else {
            if ($receiving) {
                $this->render('view-receiving', $view_data);
            } else {
                $this->render('view', $view_data);
            }
        }

    }

    /**
     *
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
                'purchases' => $purchases,
                // 'company_from' => $company_from,
                'from' => $from,
                'to' => $to), true
            )
        );

        $html2pdf->Output();
    }

    /**
     *
     */
    public function actionSetAsSent($id) 
    {
        $dispatch_note = DispatchNote::model()->findByPk($id);

        header('Content-Type: application/json');

        if ($dispatch_note->setAsSent()) {
            $response['status'] = 1;
            $response['message'] = 'Nota de envío marcado como enviado';
            die(CJSON::encode($response));

        } else {
            $response['status'] = 0;
            $response['errors'] = $dispatch_note->getErrors();
            die(CJSON::encode($response));
        }
    }

    /**
     * ESTO CREO QUE NO VA MAS 17-02-2015
     */
    // public function actionSetAsReceivedInHeadquarter($id) {
    // 	die(var_dump($_POST));
    // 	$dispatch_note = DispatchNote::model()->findByPk($id);

    // 	header('Content-Type: application/json');

    // 	if ($dispatch_note->setAsReceivedInHeadquarter()) {
    //   			$response['status'] = 1;
    //   			$response['message'] = 'Nota de envío marcado como recibido';
    //  			die(CJSON::encode($response));

    // 	} else {
    // 		$response['status'] = 0;
    // 		$response['errors'] = $dispatch_note->getErrors();
    // 		die(CJSON::encode($response));
    // 	}
    // }

    public function actionCancel($id) 
    {
        if (DispatchNote::model()->findByPk($id)->cancel()) {
            return true;
            $this->redirect(array('/headquarter/dispatchnote/expecting'));
        } else {
            Yii::app()->user->setFlash('receiving', 'Hubo un error cancelando la Nota de envío');

            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }
}