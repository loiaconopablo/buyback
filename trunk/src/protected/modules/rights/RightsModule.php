<?php

class RightsModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'rights.models.*',
			'rights.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here

			// Si no es super user no lo deja ejecutar acciones en este modulo
			// Lo redirecciona a la pagina de login
			if(!Yii::app()->user->checkAccess('superuser')) {
				$controller->redirect(Yii::app()->user->loginUrl);
			}

			$controller->main_menu = Home::getMainMenu();
		
			$controller->submenu_title = Yii::t('app', 'Roles', 2);
			
			$controller->submenu = array(
				//array('label'=>Yii::t('app', 'Asignación de roles'), 'url'=>array('/rights/authassignment/admin'), 'active' =>  Yii::app()->controller->id=='authassignment'),
				array('label'=>Yii::t('app', 'Asignación de R(oles)T(areas)O(peraciones)'), 'url'=>array('/rights/authitemchild/admin'), 'active' =>  Yii::app()->controller->id=='authitemchild'),
				array('label'=>Yii::t('app', 'CRUD RTO'), 'url'=>array('/rights/authitem/admin'), 'active' =>  Yii::app()->controller->id=='authitem'),
			);

			

			return true;
		}
		else
			return false;
	}
}