<?php

class PurchaseController extends Controller {

    public function accessRules() {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('clear', 'view', 'generateexcel'),
                'expression' => "Yii::app()->user->checkAccess('admin')",
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Muestra una posible liquidación
     * La guarda y ofrece el ecxcell
     * @param  integer $id dispatchnote_id
     */
    public function actionClear($id) {
        $model = new Purchase('search');
        $model->unsetAttributes();

        $model_rows = $model->findAllByAttributes(array('last_dispatch_note_id' => $id));

        $data_provider = $model->clear($id);
        $data_provider->setPagination(false);

        $model_rows = $data_provider->data;

        // Total de purchase_price de equipos con estado REJECTED
        $total_rejected_price = 0;
        // Total de paid_price de equipos con estados APPROVED o REQUOTED
        $total_paid_price = 0;
        // Total de la comisión sobre los paid_price tomando el company.percent_fee
        $total_comision = 0;


        foreach ($model_rows as $key => $purchase) {
            if ($purchase->current_status_id == Status::APPROVED) {
                $total_paid_price += $purchase->paid_price;

                $total_comision += $purchase->calculateComision();
            }

            if ($purchase->current_status_id == Status::REQUOTED) {
                $total_paid_price += $purchase->paid_price;

                $total_comision += $purchase->calculateComision();
            }

            if ($purchase->current_status_id == Status::REJECTED) {
                $total_rejected_price += $purchase->purchase_price;
            }
        }

        $total_paid_price = round($total_paid_price, 2);
        $total_rejected_price = round($total_rejected_price, 2);

        $error_allowance = round(($total_paid_price + $total_rejected_price) * 0.03, 2);

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            // Guarda la liquidacion

            $liquidacion = new Clearence();

            $liquidacion->company_id = $purchase->company->id;
            $liquidacion->dispatchnote_id = $purchase->last_dispatch_note->id;
            $liquidacion->total_purchase = number_format($total_rejected_price, 2, '.','');
            $liquidacion->total_paid = number_format($total_paid_price, 2, '.','');
            $liquidacion->error_allowance = number_format($error_allowance, 2, '.','');
            $liquidacion->paid_comision = number_format($total_comision, 2, '.','');
            $liquidacion->total_comision = number_format($total_comision + $error_allowance, 2, '.','');

            $transaction = Yii::app()->db->beginTransaction();

            if ($liquidacion->save()) {
                $liquidacion->refresh();

                try {
                    foreach ($model_rows as $key => $purchase) {

                        $purchase->clearence_id = $liquidacion->id;

                        if ($purchase->current_status_id == Status::APPROVED || $purchase->current_status_id == Status::REQUOTED) {
                            $purchase->comision = $purchase->calculateComision();
                        } else {
                            $purchase->comision = 0;
                        }
                        

                        $purchase->company_percent_fee = $purchase->company->percent_fee;
                        $purchase->checked_status_id = $purchase->current_status_id;

                        $purchase->setStatus(Status::PAID, $purchase->last_dispatch_note_id);
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    throw $e;
                    die('error guardando liquidacion');
                }

                $transaction->commit();

                // Se genera el Excel resultante
                $this->redirect(array('generateexcel', 'clearence_id' => $liquidacion->id));
            } else {
                $liquidacion->getErrors();
                $transaction->rollback();
            }
        }


        $this->render(
                'clear', array(
                'model' => $model,
                'dispatchnote_id' => $id,
                'total_paid_price' => $total_paid_price,
                'total_comision' => $total_comision,
                'total_rejected_price' => $total_rejected_price,
                'error_allowance' => $error_allowance,
            )
        );
    }

    /**
     * Muestra la liquidacion
     */
    public function actionView($id) {
        $clearence = Clearence::model()->findByPk($id);

        $purchases = Purchase::model()->findAllByAttributes(array('clearence_id' => $id));

        $dataProvider = new CActiveDataProvider('Purchase');
        $dataProvider->setData($purchases);

        $this->render(
                'view', array(
                'model' => $purchases,
                'dataProvider' => $dataProvider,
                'clearence' => $clearence,
            )
        );
    }

    /**
     * Genera el excel con los detalles de liquidación
     * @param  integer $clearence_id [description]
     */
    public function actionGenerateExcel($clearence_id) {
        $clearence = Clearence::model()->findByPk($clearence_id);

        $result = array();
        $columns = array();
        $columns['contract_number'] = Yii::t('app', 'Nº Contrato');
        $columns['imei'] = Yii::t('app', 'IMEI');
        $columns['brand'] = Yii::t('app', 'Marca');
        $columns['model'] = Yii::t('app', 'Modelo');
        $columns['carrier_name'] = Yii::t('app', 'Operador');
        $columns['purchase_price'] = Yii::t('app', 'Precio de Compra');
        $columns['created_at'] = Yii::t('app', 'Fecha de Compra');
        $columns['status'] = Yii::t('app', 'Estado');
        $columns['point_of_sale'] = Yii::t('app', 'Punto de Venta');
        $columns['company_code'] = Yii::t('app', 'Empresa');
        $columns['social_reason'] = Yii::t('app', 'Razón Social');
        $columns['user'] = Yii::t('app', 'Nombre de Usuario');
        $columns['dispatch_note_number'] = Yii::t('app', 'Nº Nota de Envío');
        $columns['reject_reasons'] = Yii::t('app', 'Motivos');
        $columns['imei_checked'] = Yii::t('app', 'IMEI Chequeado');
        $columns['brand_checked'] = Yii::t('app', 'Marca Chequeada');
        $columns['model_checked'] = Yii::t('app', 'Modelo Chequeado');
        $columns['carrier_checked'] = Yii::t('app', 'Operador Chequeado');
        $columns['total_paid'] = Yii::t('app', 'Precio de Liquidación');
        $columns['comment_received'] = Yii::t('app', 'Observaciones');
        $columns['total_comision'] = Yii::t('app', 'Comisión');
        array_push($result, $columns);
        
        $lastRow = 0;
        foreach ($clearence->purchases as $purchase) {
            $resultRow = array();
            $resultRow['contract_number'] = $purchase->contract_number;
            $resultRow['imei'] = $purchase->imei;
            $resultRow['brand'] = $purchase->brand;
            $resultRow['model'] = $purchase->model;
            $resultRow['carrier_name'] = $purchase->carrier_name;
            $resultRow['purchase_price'] = $purchase->purchase_price;
            $resultRow['created_at'] = date("d-m-Y", strtotime($purchase->created_at));
            $resultRow['status'] = $purchase->checked_status->name;
            $resultRow['point_of_sale'] = $purchase->point_of_sale->name;
            $resultRow['company_code'] = $purchase->company->company_code;
            $resultRow['social_reason'] = $purchase->company->social_reason;
            $resultRow['user'] = $purchase->user->username;
            $resultRow['dispatch_note_number'] = $purchase->last_dispatch_note->dispatch_note_number;
            $resultRow['reject_reasons'] = implode(" - ", CJSON::decode($purchase->questionary_json_checked));
            $resultRow['imei_checked'] = $purchase->imei_checked;
            $resultRow['brand_checked'] = $purchase->brand_checked;
            $resultRow['model_checked'] = $purchase->model_checked;
            $resultRow['carrier_checked'] = $purchase->carrier_checked;
            $resultRow['paid_price'] = $purchase->paid_price;
            $resultRow['comment_received'] = $purchase->last_dispatch_note->comment_received;
            $resultRow['comision'] = $purchase->comision;

            array_push($result, $resultRow);
            $lastRow ++;
        }
        
        Yii::import('vendor.phpoffice.phpexcel.Classes.PHPExcel', true);

        $objPHPExcel = new PHPExcel('UTF-8', false, 'Liquidacion');
        $objPHPExcel->getProperties()->setCreator("Buyback BGH");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->fromArray($result, null, 'A1');
        $objPHPExcel->getActiveSheet()->setCellValue('A'. ($lastRow + 4), 'TOTAL REINTEGRO');
        $objPHPExcel->getActiveSheet()->setCellValue('A'. ($lastRow + 5), 'COMISIONES');
        $objPHPExcel->getActiveSheet()->setCellValue('A'. ($lastRow + 6), 'AJUSTE DE COMISION');
        $objPHPExcel->getActiveSheet()->setCellValue('A'. ($lastRow + 7), 'TOTAL COMISIONES');
        $objPHPExcel->getActiveSheet()->setCellValue('B'. ($lastRow + 4), $clearence->total_paid);
        $objPHPExcel->getActiveSheet()->setCellValue('B'. ($lastRow + 5), $clearence->paid_comision);
        $objPHPExcel->getActiveSheet()->setCellValue('B'. ($lastRow + 6), $clearence->error_allowance);
        $objPHPExcel->getActiveSheet()->setCellValue('B'. ($lastRow + 7), $clearence->total_comision);
        
        // Redirect output to a client's web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="liquidacion_' . date('d-m-Y') . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}
