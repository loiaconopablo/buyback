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
    public function actionImei()
    {

        $model = new StepImeiForm;
        Yii::app()->session['purchase'] = array();

        if (isset($_POST['StepImeiForm'])) {
            $model->setAttributes($_POST['StepImeiForm']);

            if ($model->validate()) {
                Yii::app()->session['purchase'] = CMap::mergeArray(Yii::app()->session['purchase'], array('imei' => $model->imei));

                // Guarda la respuesta de gif (webservice) en session
                Yii::app()->session['gif_data'] = CJSON::decode($model->gif_data, false);

                // Agrega gif_response_json a la session para luego guardarlo en registro
                Yii::app()->session['purchase'] = CMap::mergeArray(Yii::app()->session['purchase'], array('gif_response_json' => $model->gif_data));
                
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
     * Muestra el formulario con los selects para seleccionar la marca y modelo
     */
    public function actionBrandModel()
    {
        $this->checkSession();
        
        $model = new StepBrandModelForm;

        if (isset($_POST['StepBrandModelForm'])) {
            $model->setAttributes($_POST['StepBrandModelForm']);

            if ($model->validate()) {
                Yii::app()->session['purchase'] = CMap::mergeArray(Yii::app()->session['purchase'], $_POST['StepBrandModelForm']);
     
                // TODO: Esto creo que deberia estar en savePurchase
                // Busca el dispositivo en Pricelist
                $current_price_list_device = PriceList::model()->findByAttributes(array('brand' => $_POST['StepBrandModelForm']['brand'], 'model' => $_POST['StepBrandModelForm']['model']));

                // Guarda el AR del dispocitivo finalmente selecionado
                // para comparalo contra el primeramente seleccionado gracias a GIF
                Yii::app()->session['current_price_list_device'] = $current_price_list_device;
                
                // Incrementa en 1 el registro que coincide con name, brand, model
                // o lo crea con quantity en 1
                GifDictionary::model()->incrementQuantity(Yii::app()->session['gif_data']->respuesta->name, Yii::app()->session['current_price_list_device']->brand, Yii::app()->session['current_price_list_device']->model);
                
                // Compara el registro de price_list recuperado con el gif_dictionary
                // Contra el registro de price_list seleccionado por el usuario
                // Si no coinciden repora 'RUIDO' el usuario no eligio lo miso que el diccionario
                // Si el registro recuperado con gif_dictionary es NULL no se reporta ruido sino que significa
                // que todavia no lo habia aprandido el diccionario
                $this->comparePricelistItems();

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

        $price_list_device = $this->getBrandModel();

        // Guarda en la variable de session lo que encontro en la lista de precios
        Yii::app()->session['gif_data']->price_list_device = $price_list_device;

        // Si no es NULL popula el formulario con el dispositivo que encontró
        if ($price_list_device) {
            $model->brand = $price_list_device->brand;
            $model->model = $price_list_device->model;
        }

        $this->render('step_brand_model', array('model' => $model));

    }

    /**
     * Muestra las condiciones que debe cumplir un equipo para ser comprado
     * Tiene un checkbox para acetparlas
     */
    public function actionQuestionary()
    {
        $this->checkSession();

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
     * En este paso se elique el prestdor del servicio o si esta liberado
     */
    public function actionCarrier()
    {
        $this->checkSession();

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
     * Se guardan los datos del cliente y si todo está bien se guarda la compra
     */
    public function actionSeller()
    {
        $this->checkSession();

        // Personal
        if (isset($_POST['StepCarrierForm'])) {
            Yii::app()->session['purchase'] = CMap::mergeArray(Yii::app()->session['purchase'], $_POST['StepCarrierForm']);
        }

        //
        $model = new Seller;

        if (isset($_POST['Seller'])) {

            $model->setAttributes($_POST['Seller']);

            // Inicia la transacción de DisptchNote
            $transaction = Yii::app()->getDb()->beginTransaction();

            try {
                if ($model->save()) {
                    // Guarda la compra
                    $purchase = $this->savePurchase($model, Yii::app()->request->userHostAddress);
                }

                // Ejecuta las transacciones en la base de datos
                $transaction->commit();

                //Destruye la variable de session para evitar duplicados
                unset(Yii::app()->session['purchase']);

                $this->redirect(array('showprice', 'purchase_id' => $purchase->id, 'price' => $purchase->purchase_price, 'personal_select' => $_POST['personal-select']));

            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', $e->getMessage());
                // vuelve atras lo guardado del cliente
                $transaction->rollback();
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

    /**
     * Guarda la compra y la comunica a GIF
     * @param  Seller $seller AR Seller
     */
    public function savePurchase($seller, $user_ip)
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

        try {
            /**
             * Array con la respuesta de la AFIP con los siguienes items
             * ['contract_munber'] : integer
             * ['cae'] : integer
             * ['json_response'] : string : json raw del json que devuelve la afip con todos sus datos incluido el CAE
             *
             * @var array
             */
            $cae_array = Yii::app()->wsfe->getCaeParaContrato($purchase_price, $seller);

        } catch (Exception $e) {
            throw $e;
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
            'gif_response_json' => trim(Yii::app()->session['purchase']['gif_response_json']),
            'pricelist_log' => CJSON::encode(Yii::app()->session['current_price_list_device']),
            'user_ip' => $user_ip,
            'comprobante_tipo' => Purchase::COMPROBANTE_TIPO_COMPRA,
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

    /**
     * Devuelve un json con los modelos de la marca seleccionada
     * @param  string $brand marca de equipo
     */
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
     * Intenta matchear $gif_dictionary_device con un registro de price_list
     * @return Pricelist Devuelve el AR que encontro o NULL
     */
    public function getBrandModel()
    {
      
        /**
         * Nombre del equipo en el webservice de gif
         * @var string
         */
        $gif_name = Yii::app()->session['gif_data']->respuesta->name;

        /**
         * el AC de GifDictionary del equipo por encontraro por nombre y mayor cantidad o NULL
         * @var Gifdictionary
         */
        $gif_dictionary_device = GifDictionary::model()->getParidadMasVotada($gif_name);

        /**
         * El AC de Pricelist del equipo encontrado matcheando con GifDictionary o NULL
         * @var Pricelist
         */
        $price_list_device = $this->getDeviceFromPricelist($gif_dictionary_device);

        // Devuelve el AR de Pricelist o NULL
        return $price_list_device;

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


    /**
     * Busca el dispocitivo en la lista de precios basandose en lo encontrado
     * en el diccionario de GIF
     * @param  GifDictionary $gif_dictionary_device Un objeto del diccionario
     * @return PriceList Devuelve un objeto de la lista de precios o null si no encuentra nada o no se le paso con que buscar $gif_dictionary_device
     */
    public function getDeviceFromPricelist($gif_dictionary_device)
    {
        // Si no hay dispocitivo del diccionario de GIF
        // Se retorna nulo
        if (!$gif_dictionary_device) {
            return null;
        }

        // Busca el dispositivo en Pricelist
        $price_list_device = PriceList::model()->findByAttributes(array('brand' => $gif_dictionary_device->brand, 'model' => $gif_dictionary_device->model));

        if (!count($price_list_device)) {
            // Se loguea que el diccionario no matchea con la lista de precios
            Yii::log(
                'gif_dictionary.name = ' . $gif_dictionary_device->name . ' - gif_dictionary.brand = ' . $gif_dictionary_device->brand . ' - gif_dictionary.model = ' . $gif_dictionary_device->model,
                CLogger::LEVEL_WARNING,
                'PRICELIST GIF_DICTIONARY NOT MATCH'
            );

            return null;
        }

        // Devuelve el dispocitivo encontrado en la lista de precios
        return $price_list_device;

    }

    /**
     * Compara el registro de price_list recuperado con el gif_dictionary
     * Contra el registro de price_list seleccionado por el usuario
     * (Ambos registros están guarddos en session)
     * Si no coinciden repora 'RUIDO' el usuario no eligio lo miso que el diccionario
     * Si el registro recuperado con gif_dictionary es NULL no se reporta ruido sino que significa
     * que todavia no lo habia aprandido el diccionario
     *
     * Si no coinciden
     * TODO: Levanta un ticket de ruido en GIF
     * agrega l aplication log un warning
     */
    public function comparePricelistItems()
    {
        // Si el registro recuperado con gif_dictionary es NULL no se reporta ruido sino que significa que todavia no lo habia aprandido el diccionario
        if (!Yii::app()->session['gif_data']->price_list_device) {
            return;
        }

        
        $gif_dictionary_brand = Yii::app()->session['gif_data']->price_list_device->brand;
        $current_price_list_device_brand = Yii::app()->session['current_price_list_device']->brand;
        $gif_dictionary_model = Yii::app()->session['gif_data']->price_list_device->model;
        $current_price_list_device_model = Yii::app()->session['current_price_list_device']->model;


        // Si la marca o el modelo no coinciden se trata de otro dispositivo
        // TODO: Se levanta un ticket en la plataforma GIF
        // Se escribe en el log de la aplicacion
        if (($gif_dictionary_brand != $current_price_list_device_brand) || ($gif_dictionary_model != $current_price_list_device_model)) {
            Yii::log('GIF_DICTIONARY brand: ' . $gif_dictionary_brand . ' model: ' . $gif_dictionary_model . ' | USER SELECTION brand: ' . $current_price_list_device_brand . ' model: ' . $current_price_list_device_model, CLogger::LEVEL_WARNING, 'GIF_DICTIONARY USER SELECTION NOT MATCHING');
        }
    }

    /**
     * Chequea que la variable de session que mantiene los datos de la compra atraves de los 
     * formularios exista
     * De lo contrario redirecciona a el action imei
     */
    public function checkSession()
    {
        if (!isset(Yii::app()->session['purchase'])) {
            $this->redirect('purchase/buy/imei');
        }
    }
}
