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
                'actions' => array('index', 'export'),
                'expression' => "Yii::app()->user->checkAccess('admin')",
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
	
    /**
     * Muestra la grilla con todos los filtros para realizar reportes
     */
	public function actionIndex()
	{

		$model = new Purchase('search');
        $model->unsetAttributes();

        if (isset($_GET['Purchase'])) {
            $model->setAttributes($_GET['Purchase']);

            Yii::app()->request->cookies['purchase_filters'] = new CHttpCookie('purchase_filters', CJSON::encode($_GET['Purchase']));

        }

        $this->render(
            'index',
            array(
            'model' => $model,
            )
        );
	}

    public function actionExport()
    {
        $model = new Purchase;
        $model->unsetAttributes();

        $model->setAttributes(CJSON::decode(Yii::app()->request->cookies['purchase_filters']));

        foreach ($model->search()->data as $purchase) {
            echo $purchase->contract_number . '<br>';
        }

        die();
    }

}