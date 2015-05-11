<?php
/**
 * Esta clase maneja las compras del lado del administrador OWNER
 * @author RGG <rggrinberg@gmail.com>
 */
class PurchaseController extends Controller {
	/**
	 * Define el layout que van a rederizar las vistas dl controller
	 * @var string
	 */
	public $layout = '//layouts/column2';

	/**
	 * Redirecciona a actionAdmin
	 * @author RGG <rggrinberg@gmail.com>
	 */
	public function actionIndex() {
		$this->redirect(array('admin'));
	}

	/**
	 * Muestra la tabla de equipos en poder del OWNER
	 * Status::RECIVED
	 * @author RGG <rggrinberg@gmail.com>
	 */
	public function actionAdmin() {
		$model = new Purchase;
		// $model->unsetAttributes(); commented: 07-05-2015

		if (isset($_GET['Purchase'])) {
			$model->setAttributes($_GET['Purchase']);
		}

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Muestra la table con los equipos en estado Status::IN_OBSERVATION
	 * @author RGG <rggrinberg@gmail.com>
	 */
	public function actionInObservation() {
		$model = new Purchase;

		$this->render('in_observation', array(
			'model' => $model,
		));
	}

	/**
	 * Renderiza la vista con la lista de equipos a pasar al estado IN_OBSERVATION
	 * Tambien muestra un textarea para escribir un comentario en el estado de cada equipo
	 * @author RGG <rggrinberg@gmail.com>
	 */
	public function actionSetInObservation() {
		/**
		 * Modelo (no table) del formulario que contiene el comentario
		 * con su validacion especifica
		 * @var CommentForm
		 */
		$comment_model = new CommentForm;

		$model = new Purchase;

		/**
		 * Array con las ids de los equipos que se quieren pasar al estado IN_OBSERVATION
		 * @var array
		 */
		$purchases = array();

		// Se fija si recibio purchases en el post del admin
		if (isset($_POST['purchase_selected'])) {
			$purchases = $_POST['purchase_selected'];
		}

		// Si no recibe este POST el request viene de admin
		if (isset($_POST['CommentForm'])) {
			$comment_model->setAttributes($_POST['CommentForm']);

			if ($comment_model->validate()) {
				// setea el comentario y el estado de todas las purchases del array
				$model->setPurchasesInObservation($purchases, $comment_model->comment);
			}
		}

		/*
		Genera el dataProvider con las purchase_id del request para popular la grilla en la vista
		 */
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', $purchases);

		$dataProvider = new CActiveDataProvider(new Purchase, array(
			'criteria' => $criteria,
		));

		$this->render('set_in_observation', array(
			'dataProvider' => $dataProvider,
			'model' => $model,
			'comment_model' => $comment_model,
		));
	}

	/**
	 * Renderiza la vista con la lista de equipos a pasar al estado APPROVED
	 * Tambien muestra un textarea para escribir un comentario en el estado de cada equipo
	 * @author RGG <rggrinberg@gmail.com>
	 */
	public function actionSetApproved() {
		/**
		 * Modelo (no table) del formulario que contiene el comentario
		 * con su validacion especifica
		 * @var CommentForm
		 */
		$comment_model = new CommentForm;

		$model = new Purchase;

		/**
		 * Array con las ids de los equipos que se quieren pasar al estado IN_OBSERVATION
		 * @var array
		 */
		$purchases = array();

		// Se fija si recibio purchases en el post del admin
		if (isset($_POST['purchase_selected'])) {
			$purchases = $_POST['purchase_selected'];
		}

		// Si no recibe este POST el request viene de admin
		if (isset($_POST['CommentForm'])) {
			$comment_model->setAttributes($_POST['CommentForm']);

			if ($comment_model->validate()) {
				// setea el comentario y el estado de todas las purchases del array
				$model->setPurchasesApproved($purchases, $comment_model->comment);
			}
		}

		/*
		Genera el dataProvider con las purchase_id del request para popular la grilla en la vista
		 */
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', $purchases);

		$dataProvider = new CActiveDataProvider(new Purchase, array(
			'criteria' => $criteria,
		));

		$this->render('set_approved', array(
			'dataProvider' => $dataProvider,
			'model' => $model,
			'comment_model' => $comment_model,
		));
	}
}