<?php

class DefaultController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
		);
	}

	
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			// Si la pagina no existe y esta logueado
			// Va al home que le corresponde segun su rol
			if ($error['code'] == 404) {
				$this->redirect(Home::getRoleHome());
			}

			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionMessage($type = null)
	{
		$this->layout = false;

		$output = null;

		if(Yii::app()->request->isPostRequest) {
			foreach ($_POST as $message_container) {
				foreach ($message_container as $key => $message) {
					$output .= $this->render('message', array('message' => $message, 'type' => $type), true);
				}
			}
		}

		echo $output;
	}

}