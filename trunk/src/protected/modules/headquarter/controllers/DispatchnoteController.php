<?php

class DispatchnoteController extends Controller {

	public function actionIndex() {
		$this->redirect(array('admin'));
	}

	public function actionAdmin() {
		$model = new DispatchNote('search');
		$model->unsetAttributes();

		if (isset($_GET['DispatchNote'])) {
			$model->setAttributes($_GET['DispatchNote']);
		}

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionExpecting() {
		$model = new DispatchNote('search');
		$model->unsetAttributes();

		if (isset($_GET['DispatchNote'])) {
			$model->setAttributes($_GET['DispatchNote']);
		}

		$this->render('admin _expecting', array(
			'model' => $model,
		));
	}

	public function actionHistoryOwn() {
		$model = new DispatchNote('search');
		$model->unsetAttributes();

		if (isset($_GET['DispatchNote'])) {
			$model->setAttributes($_GET['DispatchNote']);
		}

		$this->render('admin_history_own', array(
			'model' => $model,
		));
	}

	public function actionHistoryOthers() {
		$model = new DispatchNote('search');
		$model->unsetAttributes();

		if (isset($_GET['DispatchNote'])) {
			$model->setAttributes($_GET['DispatchNote']);
		}

		$this->render('admin_history_others', array(
			'model' => $model,
		));
	}
}