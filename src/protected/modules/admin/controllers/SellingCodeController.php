<?php

class SellingCodeController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('create', 'update', 'admin', 'delete', 'upload', 'index', 'processexcel', 'truncate', 'view'),
                'expression' => "Yii::app()->user->checkAccess('admin')",
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->redirect(array('admin'));
    }

    public function actionAdmin() {
        $model = new SellingCode('search');
        $model->unsetAttributes();

        if (isset($_GET['SellingCode'])) {
            $model->setAttributes($_GET['SellingCode']);
        }

        $this->render('admin', array('model' => $model,));
    }

    public function actionCreate() {
        $model = new SellingCode();

        if (isset($_POST['SellingCode'])) {
            $model->setAttributes($_POST['SellingCode']);

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
        $model = SellingCode::model()->findByPk($id);

        if (isset($_POST['SellingCode'])) {
            $model->setAttributes($_POST['SellingCode']);

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array('model' => $model));
    }

    public function actionView($id) {
        $this->render('view', array('model' => SellingCode::model()->findByPk($id)));
    }

    public function actionDelete($id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            SellingCode::model()->findByPk($id)->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(array('admin'));
            }
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionTruncate() {

        SellingCode::model()->truncate();
        Yii::app()->user->setFlash('info', Yii::t('app', 'Se eliminaron todos los registros'));

        $this->redirect(array('admin'));
    }

    public function actionUpload() {
        $model = new fileUploadForm();
        $sellingcode_model = new SellingCode();

        if (isset($_POST['fileUploadForm'])) {
            $model->attributes = $_POST['fileUploadForm'];
            $model->file = CUploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                if ($model->file->saveAs(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $model->file->getName())) {
                    $this->redirect(array('processexcel', 'filename' => $model->file->getName()));
                }
            }
        }

        $this->render('upload', array('model' => $model, 'sellingcode_model' => $sellingcode_model));
    }

    public function actionProcessExcel($filename) {

        Yii::import('vendor.phpoffice.phpexcel.Classes.PHPExcel', true);

        $file = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $filename;
        $inputFileType = PHPExcel_IOFactory::identify($file);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($file); //$file --> your filepath and filename
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        $transaction = Yii::app()->db->beginTransaction();

        for ($row = 1; $row <= $highestRow; ++$row) {
            $model = new SellingCode();

            $values = array(
                'brand' => strtoupper(trim($objWorksheet->getCellByColumnAndRow(0, $row)->getValue())),
                'model' => strtoupper(trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue())),
                'libre_a' => trim($objWorksheet->getCellByColumnAndRow(2, $row)->getValue()),
                'movistar_a' => trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue()),
                'personal_a' => trim($objWorksheet->getCellByColumnAndRow(4, $row)->getValue()),
                'claro_a' => trim($objWorksheet->getCellByColumnAndRow(5, $row)->getValue()),
                'libre_b' => trim($objWorksheet->getCellByColumnAndRow(6, $row)->getValue()),
                'movistar_b' => trim($objWorksheet->getCellByColumnAndRow(7, $row)->getValue()),
                'personal_b' => trim($objWorksheet->getCellByColumnAndRow(8, $row)->getValue()),
                'claro_b' => trim($objWorksheet->getCellByColumnAndRow(9, $row)->getValue()),
                'bad_refurbish' => trim($objWorksheet->getCellByColumnAndRow(10, $row)->getValue()),
                'bad_irreparable' => trim($objWorksheet->getCellByColumnAndRow(11, $row)->getValue()),
            );
            
            $device = $model->findByAttributes(array('brand' => $values['brand'], 'model' => $values['model']));

            if ($device) {
                $model = $device;
            }
            $model->attributes = $values;

            if ($model->validate()) {
                $model->save();
                unset($model);
            } else {
                $rowErrors = array(
                    'brand' => 'OK',
                    'model' => 'OK',
                    'libre_a' => 'OK',
                    'movistar_a' => 'OK',
                    'personal_a' => 'OK',
                    'claro_a' => 'OK',
                    'libre_b' => 'OK',
                    'movistar_b' => 'OK',
                    'personal_b' => 'OK',
                    'claro_b' => 'OK',
                    'bad_refurbish' => 'OK',
                    'bad_irreparable' => 'OK'
                );
                foreach ($model->getErrors() as $field => $value) {
                    $rowErrors[$field] = $value[0];
                }

                $errors[$row] = $rowErrors;
            }
        }

        if (isset($errors)) {
            $transaction->rollback();
            $this->render('excel_errors', array('model' => $errors));
        } else {
            $transaction->commit();
            Yii::app()->user->setFlash('info', Yii::t('app', 'Los códigos se han importado correctamente'));
            $this->redirect(array('admin'));
        }
    }

}
