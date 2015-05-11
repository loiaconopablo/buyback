<?php

class AdminController extends Controller {

	public $layout='//layouts/column2';

	

	/**
	* action
	*/
	public function actionIndex()
	{
		$this->redirect(array('admin'));
	}

	/**
	* action
	*/
	public function actionAdmin()
	{
		$model = new Purchase('search');
		$model->unsetAttributes();

		if (isset($_GET['Purchase'])) {
			$model->setAttributes($_GET['Purchase']);
		}

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	* action
	*/
	public function actionDispatchPurchases()
	{
		$dispatch_note_model = new DispatchNote;

		$purchases = array();
		// Se fija si recibio purchases en el post del admin
		if (isset($_POST['purchase_selected'])) {
			$purchases = $_POST['purchase_selected'];
		}

		// En el submit del form con comment
		if (isset($_POST['dispatch_selected'])) {
			$dispatch_note_model->setAttributes($_POST['DispatchNote']);
			$dispatch_note_id = $dispatch_note_model->create($_POST['dispatch_selected']);
			
			if ($dispatch_note_id) {
				$this->redirect(array('/dispatchnote/dispatchnote/view', 'id' => $dispatch_note_id));
			}
		}
		
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', $purchases);

		$model = new Purchase;

		$dataProvider = new CActiveDataProvider(new Purchase, array(
			'criteria' => $criteria,
		));
		$this->render('dispatch_purchase', array(
			'dataProvider' => $dataProvider,
			'model' => $model,
			'dispatch_note_model' => $dispatch_note_model,
		));
	}

}