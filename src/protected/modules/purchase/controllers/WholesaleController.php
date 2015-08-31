<?php

class WholesaleController extends Controller
{

    public $layout = '//layouts/column1.view';

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
                'actions' => array('index', 'devicedata'),
                'expression' => "Yii::app()->user->checkAccess('wholesale')",
            ),

            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Muestra el formulario para ingresar el IMEI
     * Valida el formato del imei
     * Valida el imei contra el webservice chequeando que no esté en la BLACKLIST
     * Guarda la respuesta del webservice de GIF en session para utilizarla y guardarla en el registro
     */
    public function actionIndex()
    {

        $model = new Purchase();

        Yii::app()->session['wholesale_purchase'] = $model;

        if (isset($_POST['Purchase'])) {

            Yii::app()->session['wholesale_purchase']->setAttributes($_POST['Purchase']);

            // Valida IMEI
            if (Yii::app()->session['wholesale_purchase']->validate(array('imei'))) {

                Yii::app()->session['wholesale_purchase']->setGifDataAtBuy();

                if (!Yii::app()->session['wholesale_purchase']->blacklist) {
                    // Sí NO ESTÁ en bandanegativa
                    $this->redirect(array('devicedata'));

                } else {
                    // Está en BANDA NEGATIVA
                    Yii::app()->user->setFlash('error', Yii::t('app', 'El equipo no se puede comprar. Validar con el operador.'));
                }

            }
        }

        $this->render('index', array('model' => $model));
    }

    /**
     * Muestra el formulario para seleccionar MARCA, MODELO y OPERADORA
     */
    public function actionDeviceData()
    {

        $model = Yii::app()->session['wholesale_purchase'];

        if (isset($_POST['Purchase'])) {
            Yii::app()->session['wholesale_purchase']->setAttributes($_POST['Purchase']);

            // Valida MARCA, MODELO y OPERADORA
            if (Yii::app()->session['wholesale_purchase']->validate(array('brand', 'model', 'carrier_id'))) {
                // Setea todos los datos para guardar la compra
                Yii::app()->session['wholesale_purchase']->setPriceDataAtBuy();

                Yii::app()->session['wholesale_purchase']->setAttributes(array(
                    'point_of_sale_id' => Yii::app()->user->point_of_sale_id,
                    'company_id' => Yii::app()->user->company_id,
                    'headquarter_id' => Yii::app()->user->headquarter_id,
                    'seller_id' => Yii::app()->user->company_id, // Es un caso especial "CM" donde el vendedor es la empresa
                    'user_ip' => Yii::app()->request->userHostAddress,
                    'comprobante_tipo' => Purchase::COMPROBANTE_TIPO_COMPRA_MASIVA,
                    'contract_number' => Helper::formatearNumeroDeContrato(Purchase::PUNTO_DE_VENTA_COMPRA_MASIVA, Counters::model()->getNext('wholesale_number')),
                ));

                // GUARDA LA COMPRA
                if (Yii::app()->session['wholesale_purchase']->save()) {
                    // Redirecciona para ingresar un nuevo imei
                    $this->redirect(array('index'));
                }
                
            }
        }

        $this->render('devicedata', array('model' => $model));
    }
}