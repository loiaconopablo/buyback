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

    /**
     * Exporta la busqueda a Excel
     */
    public function actionExport()
    {
        $model = new Purchase;
        
        //var_dump($model->search()->pagination->setPageSize($model->search()->totalItemCount));

        if (isset($_POST['attributes'])) {

            Yii::import('vendor.phpoffice.phpexcel.Classes.PHPExcel', true);

            
            $model->unsetAttributes();
            $model->setAttributes(CJSON::decode(Yii::app()->request->cookies['purchase_filters']));

            $dataProvider = $model->search();
            $dataProvider->setPagination(false);

            $excel_data = array();

            foreach ($dataProvider->data as $purchase) {
                $excel_row = array();

                // Attributos de la compra
                foreach ($_POST['attributes'] as $purchase_attribute) {
                    array_push($excel_row, $this->formatData($purchase_attribute, $purchase->$purchase_attribute));
                }

                // Attributos del Operador
                if (isset($_POST['carrier_attributes'])) {
                    foreach ($_POST['carrier_attributes'] as $carrier_attribute) {
                        if ($purchase->carrier) {
                            array_push($excel_row, $this->formatData($carrier_attribute, $purchase->carrier->$carrier_attribute));
                        } else {
                            array_push($excel_row, 'Liberado');
                        }
                    }
                }

                // Attributos del punto de venta
                if (isset($_POST['point_of_sale_attributes'])) {
                    foreach ($_POST['point_of_sale_attributes'] as $point_of_sale_attribute) {
                        array_push($excel_row, $this->formatData($point_of_sale_attribute, $purchase->point_of_sale->$point_of_sale_attribute));
                    }
                }

                // Attributos de la empresa
                 if (isset($_POST['compay_attributes'])) {
                    foreach ($_POST['compay_attributes'] as $compay_attribute) {
                        array_push($excel_row, $this->formatData($compay_attribute, $purchase->company->$compay_attribute));
                    }
                }

                // Attributos del usuario
                if (isset($_POST['user_attributes'])) {
                    foreach ($_POST['user_attributes'] as $user_attribute) {
                        array_push($excel_row, $this->formatData($user_attribute, $purchase->user->$user_attribute));
                    }
                }

                // Attributos del cliente
                if (isset($_POST['seller_attributes'])) {
                    foreach ($_POST['seller_attributes'] as $seller_attribute) {
                        array_push($excel_row, $this->formatData($seller_attribute, $purchase->seller->$seller_attribute));
                    }
                }

                // Attributos de la nota de envío
                if (isset($_POST['dispatchnote_attributes'])) {
                    foreach ($_POST['dispatchnote_attributes'] as $dispatchnote_attribute) {
                        if ($purchase->last_dispatch_note) {
                            array_push($excel_row, $this->formatData($dispatchnote_attribute, $purchase->last_dispatch_note->$dispatchnote_attribute));
                        } else {
                            array_push($excel_row, '');
                        }
                    }
                }

                // Attributos de la última ubicaci;on
                if (isset($_POST['last_location_attributes'])) {
                    foreach ($_POST['last_location_attributes'] as $last_location_attribute) {
                        if ($purchase->last_location) {
                            array_push($excel_row, $this->formatData($last_location_attribute, $purchase->last_location->$last_location_attribute));
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