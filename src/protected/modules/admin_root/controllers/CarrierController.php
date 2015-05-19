<?php

class CarrierController extends Controller
{


    public function actionView($id) 
    {

        $this->render(
            'view', array(
            'model' => Carrier::model()->findByPk($id),
            )
        );
    }

    public function actionCreate() 
    {

        $model = new Carrier;


        if (isset($_POST['Carrier'])) {
            $model->setAttributes($_POST['Carrier']);

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

        $model = Carrier::model()->findByPk($id);


        if (isset($_POST['Carrier'])) {
            $model->setAttributes($_POST['Carrier']);

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
            Carrier::model()->findByPk($id)->delete();

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
        
        $model = new Carrier('search');
        $model->unsetAttributes();

        if (isset($_GET['Carrier'])) {
            $model->setAttributes($_GET['Carrier']); 
        }

        $this->render(
            'admin', array(
            'model' => $model,
            )
        );
    }

}