<?php

class ListController extends Controller
{
	public function accessRules() {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index'),
                'expression' => "Yii::app()->user->checkAccess('admin')",
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

	public function actionIndex() 
    {
        $model = new DispatchNote('search');
        $model->unsetAttributes();

        if (isset($_GET['DispatchNote'])) {
            $model->setAttributes($_GET['DispatchNote']);
        }

        Helper::pushInCookie(DispatchNote::PENDING_TO_SEND, 'checkedDispatchnoteStatuses');

        $this->render(
            'dispatchnote', array(
            'model' => $model,
            )
        );
    }


    public function actionHistory() 
    {
        $model = new Clearence('search');
        $model->unsetAttributes();

        $this->render(
            'clearence', array(
            'model' => $model,
            )
        );
    }
}