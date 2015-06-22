<?php

//Yii::import('application.vendors.wsfe.*', true);
Yii::import('ext.wsfe.*', true);

class PurchaseController extends Controller
{

    public $layout = '//layouts/column1';

    /**
     *  Solo redireccionla al paso 01
     */
    public function actionIndex()
    {
        $this->redirect('retail/purchase/imei');
    }

    /**
     *  PASO 1
     */
    public function actionImei()
    {
        $model = new StepImeiForm;
        Yii::app()->session['purchase'] = array();

        if (isset($_POST['StepImeiForm'])) {
            $model->setAttributes($_POST['StepImeiForm']);

            if ($model->validate()) {
                Yii::app()->session['purchase'] = CMap::mergeArray(Yii::app()->session['purchase'], $_POST['StepImeiForm']);

                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->end();
                }

            } else {
                header('Content-type: application/json');
                echo CJSON::encode($model->getErrors());
                Yii::app()->end();

            }
        }

        $this->render('step_imei', array('model' => $model));
    }

    /**
     *  PASO 2
     */
    public function actionBrandModel()
    {
        //Yii::app()->session->open();

        $model = new StepBrandModelForm;
        if (isset($_POST['StepBrandModelForm'])) {
            $model->setAttributes($_POST['StepBrandModelForm']);

            if ($model->validate()) {
                //die(var_dump(Yii::app()->session['purchase']));
                Yii::app()->session['purchase'] = CMap::mergeArray(Yii::app()->session['purchase'], $_POST['StepBrandModelForm']);

                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->end();
                }

                $this->redirect('questionary');

            } else {
                // header('Content-type: application/json');
                // echo CJSON::encode($model->getErrors());
                // Yii::app()->end();

            }
        }

        $brand_model = $this->getBrandModel(Yii::app()->session['purchase']['imei']);

        if ($brand_model['response']) {
            $model->brand = $brand_model['brand'];
            $model->model = $brand_model['model'];
        }
        //Yii::app()->clientScript->registerCoreScript('yiiactiveform');
        $this->render('step_brand_model', array('model' => $model));

    }

    /**
     *  PASO 3
     */
    public function actionQuestionary()
    {
        $model = new StepQuestionaryForm;

        if (isset($_POST['StepQuestionaryForm'])) {
            $model->setAttributes($_POST['StepQuestionaryForm']);

            if ($model->validate()) {
                Yii::app()->session['broken'] = false;
                $this->redirect('carrier');
            } else {
                Yii::app()->session['broken'] = true;
            }

        }

        $this->render('step_questionary', array('model' => $model));
    }

    /**
     *  PASO 4
     */
    public function actionCarrier()
    {
        $model = new StepCarrierForm;

        if (isset($_POST['StepCarrierForm'])) {
            $model->setAttributes($_POST['StepCarrierForm']);

            Yii::app()->session['unlocked'] = $model->unlocked;

            if ($model->validate()) {
                Yii::app()->session['purchase'] = CMap::mergeArray(Yii::app()->session['purchase'], $_POST['StepCarrierForm']);

                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->end();
                }

            } else {
                header('Content-type: application/json');
                echo CJSON::encode($model->getErrors());
                Yii::app()->end();

            }

        }

        $this->render('step_carrier', array('model' => $model));

    }

    /**
     *  PASO 5
     */
    public function actionSeller()
    {
        // Personal
        if (isset($_POST['StepCarrierForm'])) {
            Yii::app()->session['purchase'] = CMap::mergeArray(Yii::app()->session['purchase'], $_POST['StepCarrierForm']);
        }

        //
        $model = new Seller;

        if (isset($_POST['Seller'])) {
            $model->setAttributes($_POST['Seller']);

            if ($model->save()) {
                if ($purchase = $this->savePurchase($model)) {
                    //Guardo el estado
                    $this->redirect(array('showprice', 'purchase_id' => $purchase->id, 'price' => $purchase->purchase_price, 'personal_select' => $_POST['personal-select']));

                    // if(Yii::app()->user->is_headquarter) {
                    //  $purchase->setStatus(Status::RECEIVED_IN_HEADQUARTER);
                    // }
                }
            }
        }
        //Setting correct price
        $price_list = PriceList::model()->find('brand = :brand AND  model = :model', array(':brand' => Yii::app()->session['purchase']['brand'], ':model' => Yii::app()->session['purchase']['model']));

        $price_data = $this->getPriceData($price_list);

        Yii::app()->session['purchase'] = CMap::mergeArray(Yii::app()->session['purchase'], array('price_list_id' => $price_list->id));
        Yii::app()->session['purchase'] = CMap::mergeArray(Yii::app()->session['purchase'], $price_data);

        $this->render('step_seller', array('model' => $model, 'price' => $price_data['purchase_price']));

    }

    /**
     *  PASO 6
     */
    public function actionShowPrice($price, $purchase_id, $personal_select)
    {
        $this->render('step_showprice', array('price' => $price, 'purchase_id' => $purchase_id, 'personal_select' => $personal_select));
    }

    public function actionGenerateContract($purchase_id)
    {
        $purchase = Purchase::model()->findByPk($purchase_id);
        $retail = PointOfSale::model()->findByPk($purchase->point_of_sale_id);
        $seller = Seller::model()->findByPk($purchase->seller_id);

        $carrier = Carrier::model()->findByPk($purchase->carrier_id);

        if (!$carrier) {
            $carrier_name = Yii::t('app', 'Unlocked');
        } else {
            $carrier_name = $carrier->name;
        }

        //$this->renderPartial('contract', array('model' => $purchase, 'retail' => $retail, 'seller' => $seller, 'carrier_name' => $carrier_name));
        //die();

        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->WriteHTML($this->renderPartial('contract_wrap', array('model' => $purchase, 'retail' => $retail, 'seller' => $seller, 'carrier_name' => $carrier_name), true));
        $html2pdf->Output();
    }

    public function savePurchase($seller)
    {

        $model = new Purchase;

        $point_of_sale = PointOfSale::model()->findByPk(Yii::app()->user->point_of_sale_id);
        $carrier = Carrier::model()->findByPk(Yii::app()->session['purchase']['carrier']);

        if ($carrier) {
            $carrier_name = $carrier->name;
        } else {
            $carrier_name = Yii::t('app', 'No carrier');
        }

        $company = Company::model()->findByPk(Yii::app()->user->company_id);

        $purchase_price = Yii::app()->session['purchase']['purchase_price'];

        $afipClient = new WsfeClient;


        try {
            /**
             * Array con la respuesta de la AFIP con los siguienes items
             * ['contract_munber'] : integer
             * ['cae'] : integer
             * ['json_response'] : string : json raw del json que devuelve la afip con todos sus datos incluido el CAE
             *
             * @var array
             */
            $cae_array = $afipClient->getCaeParaContrato($purchase_price, $seller);

        } catch (Exception $e) {
            Yii::app()->user->setFlash('error', $e);

            return;

        }

        /**
         * Datos que se van a guardar en el modelo Purchase
         * @var array
         */
        $purchase_data = array(
            'contract_number' => $cae_array['contract_number'],
            'company_id' => Yii::app()->user->company_id,
            'point_of_sale_id' => Yii::app()->user->point_of_sale_id,
            'headquarter_id' => $point_of_sale->headquarter_id,
            'seller_id' => $seller->getPrimaryKey(),
            'carrier_id' => Yii::app()->session['purchase']['carrier'],
            'price_list_id' => Yii::app()->session['purchase']['price_list_id'],
            'imei' => Yii::app()->session['purchase']['imei'],
            'brand' => Yii::app()->session['purchase']['brand'],
            'model' => Yii::app()->session['purchase']['model'],
            'carrier_name' => $carrier_name,
            'price_type' => Yii::app()->session['purchase']['price_type'],
            'purchase_price' => $purchase_price,
            'paid_price' => Purchase::DEFAULT_PAID_PRICE,
            'last_location_id' => Yii::app()->user->point_of_sale_id,
            'cae_response_json' => $cae_array['json_response'],
            'cae' => $cae_array['cae'],
        );

        $model->setAttributes($purchase_data);

        if ($model->save()) {
            $model->setStatus(Status::PENDING);
            return $model;
        } else {
            //die(var_dump($model->getErrors()));
            if ($model->getErrors()) {
                foreach ($model->getErrors() as $error) {
                    Yii::app()->user->setFlash('error', $error[0]);
                }
            }
            return false;
        }
    }

    public function actionRejectedPurchase()
    {
        $this->render('rejected_purchase');
    }

    public function actionGetmodels($brand)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $model = new PriceList();

            $models = $model->getModelsByBrand($brand);
            //array_unshift($models, array('name' => 'Modelo...', 'id' => null));

            echo CJSON::encode($models);
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    /***
    * TODO
    *
    *
    */
    public function getBrandModel($imei)
    {
        /*
        // Para cuando haya un servicio donde pegar con curl y obtener datos del imei
        // https://github.com/hackerone/curl/

        $output = Yii::app()->curl->get('http://www.imei.info/?imei=352148051992965');

        */
        // TODO curl
        // fake

        if ($imei == '352148051992965') {
            return array(
                'response' => 1,
                'brand' => 'SAMSUNG',
                'model' => 'GALAXY S4 MINI',
            );
        } else {
            return array(
                'response' => 1,
                'brand' => 'MARCA DESCONOCIDA',
                'model' => 'MODELO',
            );
        }
    }

    /**
     * Devuelve el precio y el tipo de precio segun los datos ingresados en el formulario
     */
    public function getPriceData($price_list)
    {
        if (Yii::app()->session['broken']) {
            $price_data = array(
                'purchase_price' => $price_list->broken_price,
                'price_type' => 'broken',
            );

        } elseif (Yii::app()->session['unlocked']) {
            $price_data = array(
                'purchase_price' => $price_list->unlocked_price,
                'price_type' => 'unlocked',
            );

        } else {
            $price_data = array(
                'purchase_price' => $price_list->locked_price,
                'price_type' => 'locked',
            );
        }

        return $price_data;
    }
}
