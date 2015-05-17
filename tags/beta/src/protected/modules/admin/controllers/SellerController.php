<?php

class SellerController extends Controller
{


    public function actionView($id) 
    {
        $this->render(
            'view', array(
            'model' => Seller::model()->findByPk($id),
            )
        );
    }

    public function actionCreate() 
    {
        $model = new Seller;


        if (isset($_POST['Seller'])) {
            $model->setAttributes($_POST['Seller']);

            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->end(); 
                }
                else {
                    $this->redirect(array('view', 'id' => $model->id)); 
                }
            }
        }

        $this->render('create', array( 'model' => $model));
    }

    public function actionUpdate($id) 
    {
        $model = Seller::model()->findByPk($id);


        if (isset($_POST['Seller'])) {
            $model->setAttributes($_POST['Seller']);

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

    public function actionDelete($id) 
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            Seller::model()->findByPk($id)->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(array('admin')); 
            }
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.')); 
        }
    }

    public function actionIndex() 
    {
        $dataProvider = new CActiveDataProvider('Seller');
        $this->render(
            'index', array(
            'dataProvider' => $dataProvider,
            )
        );
    }

    public function actionAdmin() 
    {
        $model = new Seller('search');
        $model->unsetAttributes();

        if (isset($_GET['Seller'])) {
            $model->setAttributes($_GET['Seller']); 
        }

        $this->render(
            'admin', array(
            'model' => $model,
            )
        );
    }

}