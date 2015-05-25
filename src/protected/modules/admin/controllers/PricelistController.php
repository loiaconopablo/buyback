<?php

class PricelistController extends Controller
{

    // function init()
    // {
    //  if(isset($_POST['SESSION_ID'])){
    //      $session=Yii::app()->getSession();
    //      $session->close();
    //      $session->sessionID = $_POST['SESSION_ID'];
    //      $session->open();
    //  }
    // }

    public function actionUpload()
    {

        $model = new uploadForm;
        $PriceList_model = new PriceList;

        if (isset($_POST['uploadForm'])) {
            $model->attributes = $_POST['uploadForm'];
            $model->file = CUploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                if ($model->file->saveAs(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $model->file->getName())) {
                    $this->redirect(array('processexcel', 'filename' => $model->file->getName()));
                }
                // redirect to success page
            }
        }

        $this->render('upload', array('model' => $model, 'PriceList_model' => $PriceList_model));

    }

    // public function actionUpload(){

    //  $tempFolder = Yii::getPathOfAlias('webroot').'/uploads/temp/';
    //  if( !file_exists($tempFolder) && !is_dir($tempFolder)) {
    //      mkdir($tempFolder, 0777, TRUE);
    //  }

    //  if(!file_exists($tempFolder.'/chunks') && !is_dir($tempFolder.'/chunks')) {
    //      mkdir($tempFolder.'/chunks', 0777, TRUE);
    //  }

    //   die('a');

    //  Yii::log('info', CLogger::LEVEL_INFO, 'actionUpload');

    //  if( isset($_POST['file'])) {

    //      //$myPicture=CUploadedFile::getInstanceByName('myPicture');
    //      $galleriaPicture=CUploadedFile::getInstanceByName('file');
    //      $uploadedPicture = $galleriaPicture->getName('file');
    //      $galleriaPicture_url = $tempFolder.$uploadedPicture;
    //      if(!$galleriaPicture->saveAs($galleriaPicture_url)){

    //          //if(!$myPicture->saveAs('someFile.ext')){
    //          Yii::log('info', CLogger::LEVEL_INFO, 'saveAs FALLO');
    //          throw new CHttpException(500);
    //      }else{
    //          Yii::log('info', CLogger::LEVEL_INFO, 'saveAs EXITO');
    //      }
    //      echo 1;
    //      Yii::app()->end();
    //  }
    // }

    public function actionView($id)
    {
        $this->render(
            'view',
            array(
            'model' => PriceList::model()->findByPk($id),
            )
        );
    }

    public function actionCreate()
    {
        $model = new PriceList;

        if (isset($_POST['PriceList'])) {
            $model->setAttributes($_POST['PriceList']);

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

    public function actionUpdate($id)
    {
        $model = PriceList::model()->findByPk($id);

        if (isset($_POST['PriceList'])) {
            $model->setAttributes($_POST['PriceList']);

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render(
            'update',
            array(
            'model' => $model,
            )
        );
    }

    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            PriceList::model()->findByPk($id)->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(array('admin'));
            }

        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }

    }

    public function actionIndex()
    {
        $this->redirect(array('admin'));
    }

    public function actionAdmin()
    {
        $model = new PriceList('search');
        $model->unsetAttributes();

        if (isset($_GET['PriceList'])) {
            $model->setAttributes($_GET['PriceList']);
        }

        $this->render(
            'admin',
            array(
            'model' => $model,
            )
        );
    }

    public function actionProcessExcel($filename)
    {

        Yii::import('vendor.phpoffice.phpexcel.Classes.PHPExcel', true);

        $file = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $filename;

        $inputFileType = PHPExcel_IOFactory::identify($file);

        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($file); //$file --> your filepath and filename

        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        $transaction = Yii::app()->db->beginTransaction();

        for ($row = 2; $row <= $highestRow; ++$row) {
            $model = new PriceList;

            if (!$objWorksheet->getCellByColumnAndRow(0, $row)->getValue() && !$objWorksheet->getCellByColumnAndRow(1, $row)->getValue() && !$objWorksheet->getCellByColumnAndRow(2, $row)->getValue() && !$objWorksheet->getCellByColumnAndRow(3, $row)->getValue() && !$objWorksheet->getCellByColumnAndRow(5, $row)->getValue()) {
                continue;
            }
            $values = array(
            'brand' => strtoupper(trim($objWorksheet->getCellByColumnAndRow(0, $row)->getValue())),
            'model' => strtoupper(trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue())),
            'locked_price' => $this->cleanPrice($objWorksheet->getCellByColumnAndRow(2, $row)->getValue()),
            'unlocked_price' => $this->cleanPrice($objWorksheet->getCellByColumnAndRow(3, $row)->getValue()),
            'broken_price' => $this->cleanPrice($objWorksheet->getCellByColumnAndRow(4, $row)->getValue()),

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
                foreach ($model->getErrors() as $field => $value) {
                    $values[$field] .= $value[0];
                }
                $errors[$row] = $values;
            }

        }

        if (isset($errors)) {
            $transaction->rollback();

            $this->render(
                'excel_errors',
                array(
                'model' => $errors,
                )
            );
        } else {
            $transaction->commit();
            $this->redirect(array('admin'));
        }

    }

    /***
    * Delete entire TAble
    *
    *
    */

    public function actionTruncate()
    {
        $pricelist = new PriceList();

        $pricelist->truncateTable();

        Yii::app()->user->setFlash('admin', 'Todos loa datos de la lista de precios han sido eliminados.');

        $this->redirect(array('admin'));
    }

    public function cleanPrice($price)
    {
        $price = number_format((float) $price, 2, '.', '');

        return $price;
    }
}
