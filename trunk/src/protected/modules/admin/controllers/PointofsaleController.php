<?php

class PointOfSaleController extends Controller {

	public function actionView($id) {
		$this->render('view', array(
			'model' => PointOfSale::model()->findByPk($id),
		));
	}

	public function actionCreate() {
		$model = new PointOfSale;

		if (isset($_POST['PointOfSale'])) {

			$_POST['PointOfSale']['headquarter_id'] = $_POST['PointOfSale']['headquarter_id'] == 'null' ? NULL : $_POST['PointOfSale']['headquarter_id'];

			$model->setAttributes($_POST['PointOfSale']);

			// Hereda el valor del flag is_owner de su company
			$model->is_owner = $model->company->is_owner;

			//Esto es por ahora antes de que acepten el rediseño
			// if ($model->is_headquarter) {
			// 	$model->headquarter_id = $model->find('is_owner')->id;
			// }

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

	public function actionUpdate($id) {
		$model = PointOfSale::model()->findByPk($id);

		if (isset($_POST['PointOfSale'])) {

			$_POST['PointOfSale']['headquarter_id'] = $_POST['PointOfSale']['headquarter_id'] == 'null' ? NULL : $_POST['PointOfSale']['headquarter_id'];
			$model->setAttributes($_POST['PointOfSale']);

			$model->is_owner = $model->company->is_owner;

			//Esto es por ahora antes de que acepten el rediseño
			// if ($model->is_headquarter) {
			// 	$model->headquarter_id = $model->find('is_owner')->id;
			// }

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	public function actionDelete($id) {

		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$point_of_sale = PointOfSale::model()->findByPk($id);

			if ($point_of_sale->is_owner && !Yii::app()->user->checkAccess('superuser')) {
				Yii::app()->end();
			}

			$point_of_sale->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
				$this->redirect(array('admin'));
			}

		} else {
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
		}

	}

	public function actionIndex() {
		$this->redirect(array('admin'));
	}

	public function actionAdmin() {
		$model = new PointOfSale('search');
		$model->unsetAttributes();

		if (isset($_GET['PointOfSale'])) {
			$model->setAttributes($_GET['PointOfSale']);
		}

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionHeadquarters($company_id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			//$model = new PointOfSale();

			//$headquarters = $model->getHeadquartersByCompany($company_id);

			$headquarters = Company::model()->findByPk($company_id)->getHeadquarters();

			array_unshift($headquarters, array('name' => 'Seleccionar...', 'id' => null));

			echo CJSON::encode($headquarters);
		} else {
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
		}
	}

	public function actionPointsOfSale($company_id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$model = new PointOfSale();

			$headquarters = $model->getPointsOfSaleByCompany($company_id);
			array_unshift($headquarters, array('name' => 'Seleccionar...', 'id' => null));

			echo CJSON::encode($headquarters);
		} else {
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
		}
	}
}