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
                // var_dump($_POST);
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
                        'last_location_id' => Yii::app()->user->point_of_sale_id,
                        'company_id' => Yii::app()->user->company_id,
                        'headquarter_id' => Yii::app()->user->headquarter_id,
                        'seller_id' => $model->id, // El id del seller recien guardado
                        'user_ip' => Yii::app()->request->userHostAddress,
                        'comprobante_tipo' => Purchase::COMPROBANTE_TIPO_COMPRA,
                    ));

                    try {
                        Yii::app()->session['buy_purchase']->setAfipData();

                        if (Yii::app()->session['buy_purchase']->save()) {
                        
                            Yii::app()->session['buy_purchase']->refresh();
                            Yii::app()->session['buy_purchase']->setStatus(Status::PENDING);

                            $transaction->commit();

                            $this->redirect(array('showprice', 'personal_select' => $_POST['personal-select']));

                        } else {
                            //die(var_dump(Yii::app()->session['buy_purchase']->getErrors()));
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error', 'Error guardando la compra');
                        }

                    } catch (Excaption $e) {
                        $transaction->rollback;
                        Yii::app()->user->setFlash('error', $e->getMessage());
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