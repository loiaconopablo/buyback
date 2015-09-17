<?php

class PointOfSaleController extends Controller {

//    public function filters() {
//        return array(
//            'accessControl', // perform access control for CRUD operations
//            'postOnly + delete', // we only allow deletion via POST request
//        );
//    }
//
//    public function accessRules() {
//        return array(
//            array('allow', // allow admin user to perform 'admin' and 'delete' actions
//                'actions' => array('create', 'update', 'admin', 'delete', 'multicreate', 'index'),
//                'expression' => "Yii::app()->user->checkAccess('admin')",
//            ),
//            array('deny', // deny all users
//                'users' => array('*'),
//            ),
//        );
//    }

    public function actionView($id) {
        $this->render(
                'view', array(
            'model' => PointOfSale::model()->findByPk($id),
                )
        );
    }

    public function actionCreate() {
        $model = new PointOfSale;

        if (isset($_POST['PointOfSale'])) {

            $_POST['PointOfSale']['headquarter_id'] = $_POST['PointOfSale']['headquarter_id'] == 'null' ? null : $_POST['PointOfSale']['headquarter_id'];

            $model->setAttributes($_POST['PointOfSale']);

            // Hereda el valor del flag is_owner de su company
            $model->is_owner = $model->company->is_owner;

            //Esto es por ahora antes de que acepten el rediseño
            // if ($model->is_headquarter) {
            // 	$model->headquarter_id = $model->find('is_owner')->id;
            // }

            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->end();
                } else {
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id) {
        $model = PointOfSale::model()->findByPk($id);

        if (isset($_POST['PointOfSale'])) {

            $_POST['PointOfSale']['headquarter_id'] = $_POST['PointOfSale']['headquarter_id'] == 'null' ? null : $_POST['PointOfSale']['headquarter_id'];
            $model->setAttributes($_POST['PointOfSale']);

            $model->is_owner = $model->company->is_owner;

            //Esto es por ahora antes de que acepten el rediseño
            // if ($model->is_headquarter) {
            // 	$model->headquarter_id = $model->find('is_owner')->id;
            // }

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render(
                'update', array(
            'model' => $model,
                )
        );
    }

    public function actionDelete($id) {

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $point_of_sale = PointOfSale::model()->findByPk($id);

            if ($point_of_sale->is_owner && !Yii::app()->user->checkAccess('superuser')) {
                Yii::app()->end();
            }

            $point_of_sale->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(array('admin'));
            }
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionIndex() {
        $this->redirect(array('admin'));
    }

    public function actionAdmin() {
        $model = new PointOfSale('search');
        $model->unsetAttributes();

        if (isset($_GET['PointOfSale'])) {
            $model->setAttributes($_GET['PointOfSale']);
        }

        $this->render(
                'admin', array(
            'model' => $model,
                )
        );
    }

    public function actionHeadquarters($company_id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            //$model = new PointOfSale();
            //$headquarters = $model->getHeadquartersByCompany($company_id);

            $headquarters = Company::model()->findByPk($company_id)->getHeadquarters();

            array_unshift($headquarters, array('name' => Yii::t('app', 'Seleccionar') . '...', 'id' => null));

            echo CJSON::encode($headquarters);
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionPointsOfSale($company_id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $model = new PointOfSale();

            $headquarters = $model->getPointsOfSaleByCompany($company_id);
            array_unshift($headquarters, array('name' => Yii::t('app', 'Seleccionar') . '...', 'id' => null));

            echo CJSON::encode($headquarters);
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    /**
     * Metodo que genera el formulario para realizar la carga masiva
     * Verifica que los datos y el archivo Excel introducidos sean validos
     */
    public function actionMultiCreate() {
        $model = new multiCreateForm;
        $pointofsale_model = new PointOfSale;

        if (isset($_POST['multiCreateForm'])) {
            $model->attributes = $_POST['multiCreateForm'];
            $model->file = CUploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                if ($model->file->saveAs(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $model->file->getName())) {
                    $this->redirect(array('processexcel', 'filename' => $model->file->getName(), 'company_id' => $model->company_id, 'headquarter_id' => $model->headquarter_id));
                }
            }
        }

        $this->render('multicreate', array('model' => $model, 'pointofsale_model' => $pointofsale_model));
    }

    /**
     * Procesa el archivo xls con la lista de puntos de venta
     * Muestra las lineas con errores si las hay
     * @param  string $filename Nombre del archivo xls a procesar
     */
    public function actionProcessExcel($filename, $company_id, $headquarter_id) {

        Yii::import('vendor.phpoffice.phpexcel.Classes.PHPExcel', true);

        // Se crea y configura el objeto para leer el archivo Excel
        $file = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $filename;
        $inputFileType = PHPExcel_IOFactory::identify($file);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($file); //$file --> your filepath and filename
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
        $userAutoInc = 00;


        // Arrays para generar el resultado en archivo Excel
        $result = array();
        $errors = array();

        // Se procesa cada fila
        for ($row = 1; $row <= $highestRow; ++$row) {
            // Transaccion de DB
            $transaction = Yii::app()->db->beginTransaction();

            $model = new PointOfSale;
            $provinceModel = new Province;

            $values = array(
                'company_id' => $company_id,
                'headquarter_id' => $headquarter_id,
                'is_headquarter' => 0,
                'is_owner' => 0,
                'name' => trim($objWorksheet->getCellByColumnAndRow(0, $row)->getValue()),
                'address' => trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue()),
                'province' => trim($objWorksheet->getCellByColumnAndRow(2, $row)->getValue()),
                'locality' => trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue()),
                'phone' => trim($objWorksheet->getCellByColumnAndRow(4, $row)->getValue()),
                'mail' => trim($objWorksheet->getCellByColumnAndRow(5, $row)->getValue()),
                'reference_name' => trim($objWorksheet->getCellByColumnAndRow(6, $row)->getValue()),
                'reference_phone' => trim($objWorksheet->getCellByColumnAndRow(7, $row)->getValue()),
                'reference_mail' => trim($objWorksheet->getCellByColumnAndRow(8, $row)->getValue()),
            );
            $model->attributes = $values;

            $userModel = new User;
            $user_values = array(
                'company_id' => $model->company_id,
                'point_of_sale_id' => 999,
                'username' => trim($objWorksheet->getCellByColumnAndRow(9, $row)->getValue()),
                'mail' => trim($objWorksheet->getCellByColumnAndRow(10, $row)->getValue()),
            );
            $userModel->attributes = $user_values;

            // Se valida la provincia contra la tabla de Provincias
            if (empty($model->province)) {
                $model->addError('province', 'Provincia no puede ser nulo');
            }
            $province = $provinceModel->findByAttributes(array('name' => $values['province']));
            if ($province) {
                $model->province = $province->name;
            } else {
                $model->addError('province', 'La Provincia no existe');
            }

            // Se valida el nombre de usuario como unico y en caso contrario se agrega un autoincremental
            $user = $userModel->findByAttributes(array('username' => $user_values['username']));
            if ($user) {
                $userModel->username = $user_values['username'] . $userAutoInc;
                $userAutoInc ++;
            }

            // Se validan ambos modelos
            if ($model->validate(null, false) && $userModel->validate(null, false)) {
                // Si la validacion es satisfactoria, se persisten ambos modelos
                $model->save();
                $userModel->point_of_sale_id = $model->id;
                $userModel->resetPassword();
                $userModel->save();

                $authassigment = new Authassignment;
                $authassigment->itemname = 'retail';
                $authassigment->userid = $userModel->id;

                if ($authassigment->validate()) {
                    try {
                        $auth = Yii::app()->authManager;
                        $auth->assign($authassigment->itemname, $authassigment->userid, $authassigment->bizrule, $authassigment->data);
                    } catch (CDbException $e) {
                        Yii::app()->user->setFlash('error', $e->getMessage());
                        return false;
                    }
                }

                $resultRow = array();
                array_push($resultRow, $model->name, $userModel->username, $userModel->password_generated, $userModel->mail);
                array_push($result, $resultRow);
                unset($model);
                unset($userModel);
                $transaction->commit();
            } else {
                // Si la validacion falla, se genera un arreglo dinamico de errores por cada campo
                $rowErrors = array(
                    'name' => 'OK',
                    'address' => 'OK',
                    'province' => 'OK',
                    'locality' => 'OK',
                    'phone' => 'OK',
                    'mail' => 'OK',
                    'reference_name' => 'OK',
                    'reference_phone' => 'OK',
                    'reference_mail' => 'OK',
                    'username' => 'OK',
                    'user_mail' => 'OK'
                );
                foreach ($model->getErrors() as $field => $value) {
                    $rowErrors[$field] = $value[0];
                }
                foreach ($userModel->getErrors() as $field => $value) {
                    if ($field == 'mail') {
                        $rowErrors['user_mail'] = $value[0];
                    } else {
                        $rowErrors[$field] = $value[0];
                    }
                }
                $errors[$row] = $rowErrors;
                $transaction->rollback();
            }
        }
        Yii::app()->session['result'] = $result;
        $this->render('excel_errors', array('model' => $errors,));
    }

    /**
     * Genera un archivo xls con la lista de puntos de venta y usuarios creados correctamente
     */
    public function actionResult() {
        $result = Yii::app()->session['result'];
        Yii::import('vendor.phpoffice.phpexcel.Classes.PHPExcel', true);

        $objPHPExcel = new PHPExcel('UTF-8', false, 'Punto de Venta - Alta Masiva');

        $objPHPExcel->getProperties()->setCreator("Buyback BGH");
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->fromArray($result, null, 'A1');

        // Redirect output to a client's web browser (Excel5)
        header('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment;filename="punto_venta_alta_masiva_' . date('d-m-Y') . '.xls"');
        header('Pragma', 'public');
        header('Cache-Control: max-age=1');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}
