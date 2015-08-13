<?php

class ListController extends Controller
{
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
                'actions' => array('inpointofsale'),
                'expression' => "Yii::app()->user->checkAccess('retail')",
            ),
            array(
                'allow',
                'actions' => array('inpointofsale'),
                'expression' => "Yii::app()->user->checkAccess('admin')",
            ),
            array(
                'allow',
                'actions' => array('insupervision'),
                'expression' => "Yii::app()->user->checkAccess('technical_supervisor')",
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
    * Lista los equipos en el lugar listos para ser enviados a la cabecera
    */
    public function actionInPointOfSale()
    {
        // Limpia la cookie de checkbox seleccionados en Grid
        // Para que esto funcione 'ajaxUpdate'=>true en el Grid de la vista
        if (!Yii::app()->request->isAjaxRequest) {
            unset(Yii::app()->request->cookies['checkedItems']);
        }

        $model = new Purchase;
        $model->unsetAttributes();

        if (isset($_GET['Purchase'])) {
            $model->setAttributes($_GET['Purchase']);
        }

        Helper::pushInCookie(Status::PENDING, 'checkedPurchaseStatuses');
        Helper::pushInCookie(Status::RECEIVED, 'checkedPurchaseStatuses');
        
        $this->render(
            'in_point_of_sale',
            array(
            'model' => $model,
            )
        );
    }

    /**
     * Lista los equipos recibidos en la cabecera de supervisión técnica
     */
    public function actionInSupervision()
    {
        // Limpia la cookie de checkbox seleccionados en Grid
        // Para que esto funcione 'ajaxUpdate'=>true en el Grid de la vista
        if (!Yii::app()->request->isAjaxRequest) {
            unset(Yii::app()->request->cookies['checkedItems']);
        }

        $model = new Purchase;
        $model->unsetAttributes();

        if (isset($_GET['Purchase'])) {
            $model->setAttributes($_GET['Purchase']);
        }

        Helper::pushInCookie(Status::PENDING, 'checkedPurchaseStatuses');
        Helper::pushInCookie(Status::RECEIVED, 'checkedPurchaseStatuses');
        
        $this->render(
            'in_supervision',
            array(
            'model' => $model,
            )
        );
    }
}
