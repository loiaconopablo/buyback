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
	 * Lista los equipos (purchase) listados en la tabla de admin 
	 * Tanto los de retail como los de headquarter
	 * Y los despacha en una nueva nota de envio (dispatchnote)
	 *
	 * @author Richard Gribnerg <rggrinberg@gmail.com>
	 *
	 * TODO: Este action no debería estar aca ya que también es utilizdo por el modulo headquarter
	 * Creo que debería estar en el modulo dispatchnote
	 */
	public function actionDispatchPurchases()
	{
		$dispatch_note_model = new DispatchNote;

		/**
		 * Arry de lo id de los equipos seleccionados (purchase.id)
		 * @var array
		 */
		$purchases = array();

		/*
		Se fija si recibió purchases en el post del admin
		Esto es cuando viene del action admin de (retail o headquarter)
		 */
		if (isset($_POST['purchase_selected'])) {
			$purchases = $_POST['purchase_selected'];
		}

		/*
		Si cumple la condición es porque viene del submit del form para confirmar y despachar
		los equipos (purchase) en una nota de envío (dispatchnote)		
		 */
		if (isset($_POST['DispatchNote'])) {
			$dispatch_note_model->setAttributes($_POST['DispatchNote']);
			
			$dispatch_note_id = $dispatch_note_model->create($purchases);

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