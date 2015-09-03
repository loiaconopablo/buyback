<?php

class SuperviseController extends Controller
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
                'actions' => array('index', 'imeivalidation', 'checkdevise', 'checkdevisevalidation', 'showreport', 'getmodels'),
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
     * Guarda la respuesta del webservice de GIF en session para utilizarla y guardarla en el registro
     */
    public function actionIndex($id)
    {

        $model = Purchase::model()->findByPk($id);

        $model->scenario = 'checking';

        Yii::app()->session['check_purchase'] = $model;
        Yii::app()->session['actual_purchase_attributes'] = $model->getAttributes();

        $this->render('index', array('model' => $model));
    }

    /**
     * Valida el imei via AJAX
     * Renderiza una respuesta json
     */
    public function actionImeiValidation()
    {
        $model = new ImeiForm;
 
        if (isset($_POST['Purchase'])) {
            $model->setAttributes($_POST['Purchase']);

            if ($model->validate()) {
                // Guarda la respuesta de gif (webservice) en session
                $gif_response_json_checked = Yii::app()->imeiws->check($model->imei_checked);

                Yii::app()->session['check_gif_data'] = CJSON::decode($gif_response_json_checked, false);

                Yii::app()->session['check_purchase']->setAttributes(array(
                    'imei_checked' => $model->imei_checked,
                    'gif_response_json_checked' => $gif_response_json_checked
                    )
                );

                header('Content-type: application/json');
                $response = array(
                    'error' => 0,
                    'message' => Yii::t('app', 'Todo bien')
                );
                echo CJSON::encode($response);
                Yii::app()->end();

            } else {
                header('Content-type: application/json');
                $response = array(
                    'error' => count($model->getErrors()),
                    'message' => $model->getErrors()
                );
                echo CJSON::encode($response);
                Yii::app()->end();

            }
        }
    }

    /**
     * Muestra los datos al técnico del equipo a testear después de haber chequeado el imei contra GIF
     * @param  integer $id Purchase.id
     */
    public function actionCheckDevise()
    {
        $model = Yii::app()->session['check_purchase'];

        $price_list_device = $this->getBrandModelByGifName(Yii::app()->session['check_gif_data']->respuesta->name);

        // Marca si esta en lista negra
        if (strtoupper(Yii::app()->session['check_gif_data']->respuesta->blacklist) == 'YES') {
            $model->blacklist = 1;
        }

        $model->brand = isset($price_list_device->brand) ? $price_list_device->brand : null;
        $model->model = isset($price_list_device->model) ? $price_list_device->model : null;

        $this->render('checkdevise', array('model' => $model));
    }

    /**
     * Valida los datos del formulario para poder elegir el precio a pagar
     */
    public function actionCheckDeviseValidation()
    {
        if (isset($_POST['Purchase'])) {

            Yii::app()->session['check_purchase']->setAttributes($_POST['Purchase']);

            if (Yii::app()->session['check_purchase']->validate()) {

                Yii::app()->session['check_purchase']->paid_price = $this->getPaidPrice();;

                Yii::app()->session['check_purchase']->carrier_name = Carrier::model()->findByPk(Yii::app()->session['check_purchase']->carrier_id)->name;

                if(isset($_POST['questionary'])) {
                    $reasons = array();
                    foreach($_POST['questionary'] as $key => $reason) {
                        $reasons['reason-' . $key] = $reason;
                    }
                    Yii::app()->session['check_purchase']->questionary_json_checked = CJSON::encode($reasons);
                }

                $this->setErrors();

                header('Content-type: application/json');
                $response = array(
                    'error' => 0,
                    'message' => Yii::t('app', 'Todo bien')
                );
                echo CJSON::encode($response);
                Yii::app()->end();

            } else {
                header('Content-type: application/json');
                $response = array(
                    'error' => count(Yii::app()->session['check_purchase']->getErrors()),
                    'message' => Yii::app()->session['check_purchase']->getErrors()
                );
                echo CJSON::encode($response);
                Yii::app()->end();

            }

        }
    }

    public function actionShowReport()
    {
        if (isset($_POST['form_sent'])) {
            if (Yii::app()->session['check_purchase']->validate()) {
                if (Yii::app()->session['check_purchase']->save()) {
                    Yii::app()->session['check_purchase']->setStatus(Yii::app()->session['check_purchase']->current_status_id);

                    $this->redirect(array('/purchase/list/insupervision'));

                } else {
                    if ($model->getErrors()) {
                        foreach ($model->getErrors() as $error) {
                            Yii::app()->user->setFlash('error', $error[0]);
                        }
                    }
                }
            }
        }

        $this->render('showreport', array('model' => Yii::app()->session['check_purchase']));
    }

    public function setErrors()
    {
        $messages = '';
        Yii::app()->session->remove('report_messages');

        if (Yii::app()->session['actual_purchase_attributes']['brand'] != Yii::app()->session['check_purchase']->brand) {
            $messages .= TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, Yii::t('app', 'La marca que usted seleccionó no coincide con la marca seleccionada en el momento de la compra.'));
        }

        if (Yii::app()->session['actual_purchase_attributes']['model'] != Yii::app()->session['check_purchase']->model) {
            $messages .= TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, Yii::t('app', 'El modelo que usted seleccionó no coincide con el modelo seleccionado en el momento de la compra.'));
        }

        if (Yii::app()->session['actual_purchase_attributes']['carrier_id'] != Yii::app()->session['check_purchase']->carrier_id) {
            $messages .= TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, Yii::t('app', 'El operador que usted seleccionó no coincide con el operador seleccionado en el momento de la compra.'));
        }

        if (Yii::app()->session['actual_purchase_attributes']['purchase_price'] != Yii::app()->session['check_purchase']->paid_price) {
            $messages .= TbHtml::alert(TbHtml::ALERT_COLOR_WARNING, Yii::t('app', 'El equipo será recotizado.'));
        }

        if(isset($_POST['questionary'])) {
            foreach ($_POST['questionary']as $question) {
                $messages .= TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', $question));
            }
        }

        if (strlen($messages)) {
            Yii::app()->session['report_messages'] = $messages;
        }
    }

    public function getPaidPrice()
    {
        // Si el equipo está en banda negativa no se paga
        if (Yii::app()->session['check_purchase']->blacklist) {
            Yii::app()->session['check_purchase']->current_status_id = Status::REJECTED;
            return 0;
        }
        // Si el equipo no cumple con todas las condiciones del cuestionario no se paga
        if(isset($_POST['questionary'])) {
            Yii::app()->session['check_purchase']->current_status_id = Status::REJECTED;
            return 0;
        }

        $price_data = $this->getPriceData();
        // Si cambió la marca devuelve el nuevo precio de la lista de precios actual
        if (Yii::app()->session['actual_purchase_attributes']['brand'] != Yii::app()->session['check_purchase']->brand) {
            Yii::app()->session['check_purchase']->current_status_id = Status::REQUOTED;
            return $price_data['purchase_price'];
        }
        // Si cambió el modelo devuelve el nuevo precio de la lista de precios actual
        if (Yii::app()->session['actual_purchase_attributes']['model'] != Yii::app()->session['check_purchase']->model) {
            Yii::app()->session['check_purchase']->current_status_id = Status::REQUOTED;
            return $price_data['purchase_price'];
        }
        // Si solo cambio el prestador devuelve el preico de la linea de price_list logeada en el registro de la compra
        if (Yii::app()->session['actual_purchase_attributes']['carrier_id'] != Yii::app()->session['check_purchase']->carrier_id) {
            if (Yii::app()->session['check_purchase']->carrier_id == Carrier::model()->findByAttributes(array('name' => 'Liberado'))->id) {
                $price_type = 'unlocked_price';
            } else {
                $price_type = 'locked_price';
            }

            $price_log = Yii::app()->session['check_purchase']->getLoggedPrice($price_type);
            
            if ($price_log !== false) {
                Yii::app()->session['check_purchase']->current_status_id = Status::REQUOTED;
                return $price_log;

            } else {
                Yii::app()->session['check_purchase']->current_status_id = Status::REQUOTED;
                return $price_data['purchase_price'];

            }
            
        }

        // Si no suffrio ninguna variación devuelve el mismo precio de compra
        Yii::app()->session['check_purchase']->current_status_id = Status::APPROVED;
        return Yii::app()->session['actual_purchase_attributes']['purchase_price'];
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
     * Intenta matchear $gif_dictionary_device con un registro de price_list
     * @return Pricelist Devuelve el AR que encontro o NULL
     */
    public function getBrandModelByGifName($gif_name)
    {

        /**
         * el AR de GifDictionary del equipo por encontrar o por nombre y mayor cantidad o NULL
         * @var Gifdictionary
         */
        $gif_dictionary_device = GifDictionary::model()->getParidadMasVotada($gif_name);

        /**
         * El AR de Pricelist del equipo encontrado matcheando con GifDictionary o NULL
         * @var Pricelist
         */
        $price_list_device = $this->getDeviceFromPricelist($gif_dictionary_device);

        // Devuelve el AR de Pricelist o NULL
        return $price_list_device;

    }

    /**
     * Devuelve el precio y el tipo de precio segun los datos ingresados en el formulario
     */
    public function getPriceData()
    {
        $price_list = PriceList::model()->findByAttributes(array('brand' => Yii::app()->session['check_purchase']->brand, 'model' => Yii::app()->session['check_purchase']->model));

        if ($price_list) {

            if (Yii::app()->session['check_purchase']->carrier_id == Carrier::model()->findByAttributes(array('name' => 'Liberado'))->id) {
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

        } else {
            // No existe en la lista de precios
            return 0;
        }
        
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

}
