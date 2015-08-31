<?php

class BuyController extends Controller
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
                'actions' => array('index', 'imei', 'brandmodel', 'questionary', 'carrier', 'seller', 'showprice', 'getmodels'),
                'expression' => "Yii::app()->user->checkAccess('retail')",
            ),
            array(
                'allow',
                'actions' => array('cancel'),
                'expression' => "Yii::app()->user->checkAccess('admin')",
            ),
            array(
                'allow',
                'actions' => array('getmodels'),
                'expression' => "Yii::app()->user->checkAccess('technical_supervisor')",
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
     * Guarda el atributo 'name' del webservice en session para uso interno del sistema en las acciones que siguen
     */
    public function actionIndex()
    {

        $model = new Purchase();

        Yii::app()->session['buy_purchase'] = $model;

        if (isset($_POST['Purchase'])) {

            Yii::app()->session['buy_purchase']->setAttributes($_POST['Purchase']);

            // Valida IMEI
            if (Yii::app()->session['buy_purchase']->validate(array('imei'))) {

                Yii::app()->session['buy_purchase']->setGifDataAtBuy();

                if (!Yii::app()->session['buy_purchase']->blacklist) {
                    // Sí NO ESTÁ en bandanegativa
                    $this->redirect(array('brandmodel'));

                } else {
                    // Está en BANDA NEGATIVA
                    Yii::app()->user->setFlash('error', Yii::t('app', 'El equipo no se puede comprar. Validar con el operador.'));
                }

            }
        }

        $this->render('step_imei', array('model' => $model));
    }

    /**
     * Muestra el formulario con los selects para seleccionar la marca y modelo
     */
    public function actionBrandModel()
    {
        $model = Yii::app()->session['buy_purchase'];

        if (isset($_POST['Purchase'])) {

            Yii::app()->session['buy_purchase']->setAttributes($_POST['Purchase']);

            if (Yii::app()->session['buy_purchase']->validate(array('imei', 'brand', 'model'))) {

                $this->redirect('questionary');

            }
        }

        $this->render('step_brand_model', array('model' => $model));

    }

    /**
     * Muestra las condiciones que debe cumplir un equipo para ser comprado
     * Tiene un checkbox para acetparlas
     */
    public function actionQuestionary()
    {
        $model = new StepQuestionaryForm;

        if (isset($_POST['StepQuestionaryForm'])) {
            $model->setAttributes($_POST['StepQuestionaryForm']);

            if ($model->validate()) {

                $this->redirect('carrier');

            } 
        }

        $this->render('step_questionary', array('model' => $model));
    }

    /**
     * En este paso se elique el prestdor del servicio o si esta liberado
     */
    public function actionCarrier()
    {
        $model = Yii::app()->session['buy_purchase'];

        if (isset($_POST['Purchase'])) {

            Yii::app()->session['buy_purchase']->setAttributes($_POST['Purchase']);

            if (Yii::app()->session['buy_purchase']->validate(array('imei', 'brand', 'model', 'carrier_id'))) {

                // Setea todos los datos para guardar la compra
                Yii::app()->session['buy_purchase']->setPriceDataAtBuy();

                $this->redirect(array('seller'));

            }

        }

        $this->render('step_carrier', array('model' => $model));

    }
    /**
     * Se guardan los datos del cliente y si todo está bien se guarda la compra
     */
    public function actionSeller()
    {
        $model = new Seller;

        if (isset($_POST['Seller'])) {
            // Si es rol "requoter" puede haber cambiado el precio
            if (Yii::app()->user->checkAccess('requoter')) {
                Yii::app()->session['buy_purchase']->setAttributes(array('purchase_price' => $_POST['price']));
            }

            $model->setAttributes($_POST['Seller']);

            if ($model->validate()) {

                // Inicia la transacción de DisptchNote
                $transaction = Yii::app()->getDb()->beginTransaction();

                if ($model->save()) {

                    $model->refresh();

                    // Setea los últimos campos de purchase
                    Yii::app()->session['buy_purchase']->setAttributes(array(
                        'point_of_sale_id' => Yii::app()->user->point_of_sale_id,
                        'company_id' => Yii::app()->user->company_id,
                        'headquarter_id' => Yii::app()->user->headquarter_id,
                        'seller_id' => $model->id, // El id del seller recien guardado
                        'user_ip' => Yii::app()->request->userHostAddress,
                        'comprobante_tipo' => Purchase::COMPROBANTE_TIPO_COMPRA,
                        'contract_number' => Helper::formatearNumeroDeContrato(Purchase::PUNTO_DE_VENTA_COMPRA_MASIVA, Counters::model()->getNext('wholesale_number')),
                    ));

                    try {
                        Yii::app()->session['buy_purchase']->setAfipData();
                    } catch (Excaption $e) {
                        $transaction->rollback;
                        Yii::app()->user->setFlash('error', $e->getMessage());
                        break;
                    }

                    if (Yii::app()->session['buy_purchase']->save()) {
                        $transaction->commit();

                        $this->redirect(array('showprice', 'personal_select' => $_POST['personal-select']));

                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', Yii::app()->session['buy_purchase']->getErrors());
                        break;
                    }

                }
            }
        }

        $this->render('step_seller', array('model' => $model, 'showprice' => $this->showPriceRender(Yii::app()->session['buy_purchase']->purchase_price)));

    }

    /**
     *  PASO 6
     */
    public function actionShowPrice($personal_select)
    {
        $this->render('step_showprice', array('model' => Yii::app()->session['buy_purchase'], 'personal_select' => $personal_select));
    }


    /**
     * Anula una compra generando su respectiva nota de credito asociada
     * @param  int $id Purchase.id
     */
    public function actionCancel($id)
    {
        $associate_purchase = Purchase::model()->findByPk($id);
        
        $new_purchase = new Purchase;
        // Duplica los datos sin id
        $data = $associate_purchase->attributes;
        unset($data['id']);
        $new_purchase->setAttributes($data, false);

        // Inicia la transacción de DisptchNote
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {
            /**
             * Array con la respuesta de la AFIP con los siguienes items
             * ['contract_munber'] : integer
             * ['cae'] : integer
             * ['json_response'] : string : json raw del json que devuelve la afip con todos sus datos incluido el CAE
             *
             * @var array
             */
            $cae_array = Yii::app()->wsfe->getCaeParaContrato($associate_purchase->purchase_price, $associate_purchase->seller);

            // Guarda los datos del CAE
            $new_purchase->contract_number = $cae_array['contract_number'];
            $new_purchase->cae_response_json = $cae_array['json_response'];
            $new_purchase->cae = $cae_array['cae'];
            // Pone el precio en negativo
            $new_purchase->purchase_price = -($associate_purchase->purchase_price);
            // Marca el contrato como NOTA DE CREDITO
            $new_purchase->comprobante_tipo = 'NC';
            // Guarda el contrato asociado que debe anular
            $new_purchase->associate_row = $associate_purchase->id;

            $new_purchase->save();
            // Crea el estado canclation
            $new_purchase->setStatus(Status::CANCELLATION);

            // Actualiza la compra anulada
            $associate_purchase->associate_row = $new_purchase->id;
            $associate_purchase->setStatus(Status::CANCELLED);

            // No ocurrió ningún error
            // Ejecuta la transacción
            $transaction->commit();
            // Genera la respuesta para el javascript
            $response['status'] = 1;
            $response['purchase_id'] = $new_purchase->id;
            $response['message'] = 'Cancelación de compra generada.';
            //$this->renderJSON($response);
            die(CJSON::encode($response));

        } catch (Exception $e) {
            $transaction->rollback();
            // Genera la respuesta para el javascript
            $response['status'] = 0;
            $response['errors'] = $e->getMessage();
            // $this->renderJSON($response);
            die(CJSON::encode($response));
        }
    }

    /**
     * Devuelve el renderizado de showprice dependiendo del rol
     * @param  [type] $price_list [description]
     * @return string            [Renderizado]
     */
    public function showPriceRender($price_value = 0.00)
    {
        if (Yii::app()->user->checkAccess('personal')) {
            return $this->renderPartial('showprice_personal', array('price' => $price_value), true);
        }

        if (Yii::app()->user->checkAccess('requoter')) {
            return $this->renderPartial('showprice_requoter', array('price' => $price_value), true);
        }

        return $this->renderPartial('showprice', array('price' => $price_value), true);
    }
}