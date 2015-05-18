<?php

class CompanyController extends Controller
{

    public function actionView($id) 
    {
        $this->render(
            'view', array(
            'model' => Company::model()->findByPk($id),
            )
        );
    }

    public function actionCreate() 
    {
        $model = new Company;

        if (isset($_POST['Company'])) {
            $model->setAttributes($_POST['Company']);

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
        $model = Company::model()->findByPk($id);

        if (isset($_POST['Company'])) {
            $model->setAttributes($_POST['Company']);

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
            $company = Company::model()->findByPk($id);

            if ($company->is_owner && !Yii::app()->user->checkAccess('superuser')) {
                Yii::app()->end();
            }

            $company->delete();

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
        $model = new Company('search');
        $model->unsetAttributes();

        if (isset($_GET['Company'])) {
            $model->setAttributes($_GET['Company']);
        }

        $this->render(
            'admin', array(
            'model' => $model,
            )
        );
    }

}