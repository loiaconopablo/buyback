<?php

class PurchaseController extends Controller
{
	// Uncomment the following methods and override them if needed
	
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
                'actions' => array('index', 'export'),
                'expression' => "Yii::app()->user->checkAccess('admin')",
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
	
    /**
     * Muestra la grilla con todos los filtros para realizar reportes
     */
	public function actionIndex()
	{

		$model = new Purchase('search');
        $model->unsetAttributes();

        if (isset($_GET['Purchase'])) {
            $model->setAttributes($_GET['Purchase']);

            Yii::app()->request->cookies['purchase_filters'] = new CHttpCookie('purchase_filters', CJSON::encode($_GET['Purchase']));

        }

        if(!Yii::app()->request->isAjaxRequest) {
        	// Limpia la variable que mantiene los filtros
			unset(Yii::app()->request->cookies['purchase_filters']);
        }

        $this->render(
            'index',
            array(
            'model' => $model,
            )
        );
	}

    public function actionExport()
    {
        $model = new Purchase('search');

        if (isset($_POST['attributes'])) {

            Yii::import('vendor.phpoffice.phpexcel.Classes.PHPExcel', true);

            $model->unsetAttributes();
            $model->setAttributes(CJSON::decode(Yii::app()->request->cookies['purchase_filters']));

            $excel_data = array();

            foreach ($model->search()->data as $purchase) {
                $excel_row = array();

                // Attributos de la compra
                foreach ($_POST['attributes'] as $purchase_attribute) {
                    array_push($excel_row, $purchase->$purchase_attribute);
                }

                // Attributos del Operador
                if (isset($_POST['carrier_attributes'])) {
                    foreach ($_POST['carrier_attributes'] as $carrier_attribute) {
                        if ($purchase->carrier) {
                            array_push($excel_row, $purchase->carrier->$carrier_attribute);
                        } else {
                            array_push($excel_row, 'Liberado');
                        }
                    }
                }

                // Attributos del punto de venta
                if (isset($_POST['compay_attributes'])) {
                    foreach ($_POST['compay_attributes'] as $compay_attribute) {
                        array_push($excel_row, $purchase->company->$compay_attribute);
                    }
                }

                // Attributos de la empresa
                if (isset($_POST['point_of_sale_attributes'])) {
                    foreach ($_POST['point_of_sale_attributes'] as $point_of_sale_attribute) {
                        array_push($excel_row, $purchase->point_of_sale->$point_of_sale_attribute);
                    }
                }

                // Attributos del usuario
                if (isset($_POST['user_attributes'])) {
                    foreach ($_POST['user_attributes'] as $user_attribute) {
                        array_push($excel_row, $purchase->user->$user_attribute);
                    }
                }

                // Attributos del cliente
                if (isset($_POST['seller_attributes'])) {
                    foreach ($_POST['seller_attributes'] as $seller_attribute) {
                        array_push($excel_row, $purchase->seller->$seller_attribute);
                    }
                }

                // Attributos de la nota de envío
                if (isset($_POST['dispatchnote_attributes'])) {
                    foreach ($_POST['dispatchnote_attributes'] as $dispatchnote_attribute) {
                        if ($purchase->last_dispatch_note) {
                            array_push($excel_row, $purchase->last_dispatch_note->$dispatchnote_attribute);
                        } else {
                            array_push($excel_row, '');
                        }
                    }
                }

                // Attributos de la última ubicaci;on
                if (isset($_POST['last_location_attributes'])) {
                    foreach ($_POST['last_location_attributes'] as $last_location_attribute) {
                        if ($purchase->last_location) {
                            array_push($excel_row, $purchase->last_location->$last_location_attribute);
                        } else {
                            array_push($excel_row, '');
                        }
                    }
                }

                // inserta la fila
                array_push($excel_data, $excel_row);
            }

            $objPHPExcel = new PHPExcel('UTF-8', false, 'My Test Sheet');

            $objPHPExcel->getProperties()->setCreator("Buyback BGH");
            $objPHPExcel->setActiveSheetIndex(0);

            $objPHPExcel->getActiveSheet()->fromArray($excel_data, null, 'A1');
            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename=" reporte_' . date('d-m-Y') . '.xls"');
            header('Cache-Control: max-age=0');
             
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }

        $this->render('export', array('model' => $model));
    }

}