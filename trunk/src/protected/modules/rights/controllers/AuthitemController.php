<?php

class AuthitemController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>Authitem::model()->findByPk($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Authitem;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Authitem'])) {
			$model->attributes=$_POST['Authitem'];
			if($model->validate()){
				try {
					if (strcmp ( $model->type, 'task' ) == 0) {
						$auth = Yii::app ()->authManager;
						$auth->createTask ( $model->name, $model->description, $model->bizrule, $model->data );
					} elseif (strcmp ( $model->type, 'role' ) == 0) {
						$auth = Yii::app ()->authManager;
						$auth->createRole ( $model->name, $model->description, $model->bizrule, $model->data );
					} elseif (strcmp ( $model->type, 'operation' ) == 0) {
						$auth = Yii::app ()->authManager;
						$auth->createOperation ( $model->name, $model->description, $model->bizrule, $model->data );
					}
				} catch ( CDbException $e ) {
					Yii::app ()->user->setFlash ( 'error', $e->getMessage () );
				}
				//if ($model->save()) {
					$this->redirect(array('view','id'=>$model->name));
				//}
			}
		}
		$data['authtype'] = array('role'=>'Rol','task'=>'Tarea','operation'=>'Operacion');
		

		$this->render('create',array(
			'model'=>$model,
			'data'=>$data
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			Authitem::model()->findByPk($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->forward('admin');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Authitem('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Authitem'])) {
			$model->attributes=$_GET['Authitem'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Authitem the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Authitem::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Authitem $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='authitem-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}