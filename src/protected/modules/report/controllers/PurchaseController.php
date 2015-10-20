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
                'actions' => array('index', 'export', 'monthly'),
                'expression' => "Yii::app()->user->checkAccess('admin')",
            ),
            array(
                'allow',
                'actions' => array('index', 'export'),
                'expression' => "Yii::app()->user->checkAccess('company_admin')",
            ),
            array(
                'allow',
                'actions' => array('index', 'export'),
                'expression' => "Yii::app()->user->checkAccess('technical_supervisor')",
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
            'report_' . $this->getViewByRol(),
            array(
            'model' => $model,
            )
        );
	}

    /**
     * Devuelve al nombre de la vista a renderizar dependiendo del rol
     * @return string view name
     */
    public function getViewByRol()
    {
        if (Yii::app()->user->checkAccess('admin')) {
            return 'admin';
        }

        if (Yii::app()->user->checkAccess('company_admin')) {
            return 'company_admin';
        }

        if (Yii::app()->user->checkAccess('technical_supervisor')) {
            return 'technical_supervisor';
        }
    }

    /**
     * Exporta la busqueda a Excel
     */
    public function actionExport()
    {
        $model = new Purchase;
        
        if (isset($_POST['purchase'])) {

            Yii::import('vendor.phpoffice.phpexcel.Classes.PHPExcel', true);

            $model->unsetAttributes();
            $model->setAttributes(CJSON::decode(Yii::app()->request->cookies['purchase_filters']));

            if (Yii::app()->user->checkAccess('admin')) {
                $dataProvider = $model->search();
            }
            
            if (Yii::app()->user->checkAccess('company_admin')) {
                $dataProvider = $model->company();
            }
            
            if (Yii::app()->user->checkAccess('technical_supervisor')) {
                $dataProvider = $model->technicalsupervisor();
            }
            
            $dataProvider->setPagination(false);

            $excel_data = array();

            $column_names = $this->getColumnNames($_POST);
            array_push($excel_data, $column_names);

            foreach ($dataProvider->data as $purchase) {
                $excel_row = array();

                // Attributos de la compra
                if (isset($_POST['purchase'])) {
                    foreach ($_POST['purchase'] as $purchase_attribute) {
                        array_push($excel_row, $this->formatData($purchase_attribute, $purchase->$purchase_attribute));
                    }
                }

                // Attributos del estado actual
                if (isset($_POST['current_status'])) {
                    foreach ($_POST['current_status'] as $current_status_attribute) {
                        array_push($excel_row, $this->formatData($current_status_attribute, $purchase->getLastStatus()->$current_status_attribute));
                    }
                }
                

                // Attributos del punto de venta
                if (isset($_POST['point_of_sale'])) {
                    foreach ($_POST['point_of_sale'] as $point_of_sale_attribute) {
                        array_push($excel_row, $this->formatData($point_of_sale_attribute, $purchase->point_of_sale->$point_of_sale_attribute));
                    }
                }

                // Attributos de la empresa
                 if (isset($_POST['company'])) {
                    foreach ($_POST['company'] as $company_attribute) {
                        array_push($excel_row, $this->formatData($company_attribute, $purchase->company->$company_attribute));
                    }
                }

                // Attributos del usuario
                if (isset($_POST['user'])) {
                    foreach ($_POST['user'] as $user_attribute) {
                        array_push($excel_row, $this->formatData($user_attribute, $purchase->user->$user_attribute));
                    }
                }

                // Attributos del cliente
                if (isset($_POST['seller'])) {
                    foreach ($_POST['seller'] as $seller_attribute) {
                        array_push($excel_row, $this->formatData($seller_attribute, $purchase->seller->$seller_attribute));
                    }
                }

                // Attributos de la nota de envío
                if (isset($_POST['last_dispatch_note'])) {
                    foreach ($_POST['last_dispatch_note'] as $dispatchnote_attribute) {
                        if ($purchase->last_dispatch_note) {
                            array_push($excel_row, $this->formatData($dispatchnote_attribute, $purchase->last_dispatch_note->$dispatchnote_attribute));
                        } else {
                            array_push($excel_row, '');
                        }
                    }
                }

                // Attributos de la última ubicaci;on
                if (isset($_POST['last_location'])) {
                    foreach ($_POST['last_location'] as $last_location_attribute) {
                        if ($purchase->last_location) {
                            array_push($excel_row, $this->formatData($last_location_attribute, $purchase->last_location->$last_location_attribute));
                        } else {
                            array_push($excel_row, '');
                        }
                    }
                }

                // Attributos de la compra
                if (isset($_POST['purchase_checked'])) {
                    foreach ($_POST['purchase_checked'] as $purchase_attribute) {
                        array_push($excel_row, $this->formatData($purchase_attribute, $purchase->$purchase_attribute));
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

        $this->render('export_' . $this->getViewByRol(), array('model' => $model));
    }


    public function getColumnNames($post_request)
    {
        $purchase = new Purchase;
        $excel_row = array();

        foreach ($post_request as $clase => $attributes) {
            if (is_array($attributes)) {
                foreach ($attributes as $attribute) {

                    if (!is_object($clase == 'purchase_checked')) {
                        array_push($excel_row, $purchase->getAttributeLabel($attribute));
                        continue;
                    }

                    if (!is_object($purchase->$clase)) {
                        array_push($excel_row, $purchase->getAttributeLabel($attribute));
                        continue;
                    }

                    if (is_object($purchase->$clase)) {
                        array_push($excel_row, $purchase->getAttributeLabel($purchase->$clase->$attribute));
                        continue;
                    }
                }
            }
        }

        return $excel_row;
    }


    public function formatData($attribute, $data)
    {
        if ($attribute == 'created_at' || $attribute == 'updated_at') {
            return date("d-m-Y h:i", strtotime($data));
        }

        return $data;
    }

    /**
     * Emite un reporte para el mes seleccionado
     */
    public function actionMonthly()
    {
        $this->layout = '//layouts/column1.view';

        $model = new MonthlyForm;

        if (isset($_POST['MonthlyForm'])) {

            $model->month = $_POST['MonthlyForm']['month'];
            $model->year = $_POST['MonthlyForm']['year'];

        } else {

            $date['year'] = (int) date('Y', time());
            $date['month'] = (int) date('m', time());

            $model->month = $date['month'];
            $model->year = $date['year'];
        }
        
        $view_data = array();

        // Calcula los dias habiles sin descontar los feriados
        $fromDate = $model->year . '-' . $model->month . '-01';
        $toDate = date("Y-m-t", strtotime($fromDate)) . ' 23:59:59';
       // die(var_dump($toDate));
        $dias_habiles_del_mes = DateHelper::numberOfWorkingDaysBetweenDates($fromDate, $toDate);

        // Calcula los dias habiles transcurridos
        if (strtotime($toDate) > time()) {
            $toDate = date("Y-m-d", time());
        }
        $dias_habiles_transcurridos = DateHelper::numberOfWorkingDaysBetweenDates($fromDate, $toDate);

        $view_data['dias_habiles_del_mes'] = $dias_habiles_del_mes;
        $view_data['dias_habiles_transcurridos'] = $dias_habiles_transcurridos;

        // Obtiene el forecast para el mes
        $forecast = Forecast::model()->getForecastByYearMonth($model->year, $model->month);
        $view_data['forecast'] = $forecast;

        // Calcula la cantidad de las compras
        $total_compras = Purchase::model()->getTotalPurchaseBetweenDates($fromDate, $toDate);

        $view_data['total_compras'] = count($total_compras);

        // Calcula el promedio diario
        $promedio_diario = $view_data['total_compras'] / $dias_habiles_transcurridos;
        $view_data['promedio_diario'] = round($promedio_diario, 2);
        // Calcula la proyección al cierre
        $proyeccion_cierre = $dias_habiles_del_mes * $promedio_diario;
        $view_data['proyeccion_cierre'] = round($proyeccion_cierre, 2);

        $cierre_forecast = $view_data['total_compras'] / $forecast;
        $view_data['cierre_forecast'] = round($cierre_forecast, 2);

        // Calcula la cantidad de equipos compradospor marca en el mes
        $cantidad_por_marca = Purchase::model()->getBrandQuantitiesBetweenDates($fromDate, $toDate);
      
        $view_data['cantidad_por_marca'] = $cantidad_por_marca;

        // Calcula el promedio de precio por marca en el mes
        $precio_promedio_por_marca = Purchase::model()->getBrandPriceAverageBetweenDates($fromDate, $toDate);

        $view_data['precio_promedio_por_marca'] = $precio_promedio_por_marca;

        // Compras por punto de venta
        $pdv = PointOfSale::model()->findAll();
        $cantidad_pdv_habilitados = count($pdv);
        $view_data['cantidad_pdv_habilitados'] = $cantidad_pdv_habilitados;

        $pdv_operativos = Purchase::model()->getWorkingPointsOfSaleBetweenDates('000-00-00', date('Y-m-t', time()));
        $cantidad_pdv_operativos = count($pdv_operativos) ? count($pdv_operativos) : 1 ;
        $view_data['cantidad_pdv_operativos'] = $cantidad_pdv_operativos;
        
        $pdv_efectivos = Purchase::model()->getWorkingPointsOfSaleBetweenDates($fromDate, $toDate);
        $cantidad_pdv_efectivos = count($pdv_efectivos) ? count($pdv_efectivos) : 1 ;
        $view_data['cantidad_pdv_efectivos'] = $cantidad_pdv_efectivos;

        $promedio_por_pdv = round($view_data['total_compras'] / $cantidad_pdv_efectivos, 2);
        $view_data['promedio_por_pdv'] = $promedio_por_pdv;

        $this->render('monthly', array('model' => $model, 'view_data' => $view_data));
    }

}