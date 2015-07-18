<?php

class PurchaseController extends Controller
{
	// Uncomment the following methods and override them if needed
	
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
                'actions' => array('index'),
                'expression' => "Yii::app()->user->checkAccess('admin')",
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
	

	public function actionIndex()
	{

		$model = new Purchase('search');
        $model->unsetAttributes();

        if (isset($_GET['Purchase'])) {
            $model->setAttributes($_GET['Purchase']);
        }

        if(!Yii::app()->request->isAjaxRequest) {
        	// Limpia la cookie de filtro por estado
			unset(Yii::app()->request->cookies['checkedPurchaseStatuses']);
        }

        $this->render(
            'index',
            array(
            'model' => $model,
            )
        );
	}

}