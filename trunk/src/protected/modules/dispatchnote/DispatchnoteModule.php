<?php

class DispatchnoteModule extends CWebModule
{
	public $defaultController = 'dispatchnote';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'dispatchnote.models.*',
			'dispatchnote.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			
			// Ese metodo tambien setea el subtitulo de la seccion Ej. "Garbarino / Sucursal Primera Junta"
			$controller->main_menu = Home::getMainMenu();

			if(Yii::app()->user->checkAccess('admin')) {
				$controller->submenu_title = Yii::t('app', 'Notas de envío');
				
				$controller->submenu = array(
					array('label'=>Yii::t('app', 'Pendientes', 2), 'url'=>array('/owner/dispatchnote/expecting'), 'active' =>  Yii::app()->controller->id=='expecting'),
					array('label'=>Yii::t('app', 'Historial', 2), 'url'=>array('/owner/dispatchnote/admin'), 'active' =>  Yii::app()->controller->id=='pointofsale'),
				);
			}

			return true;
		}
		else
			return false;
	}
}
