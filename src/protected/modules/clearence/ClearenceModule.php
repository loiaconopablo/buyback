<?php

class ClearenceModule extends CWebModule
{
	public $defaultController = 'list';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'clearence.models.*',
			'clearence.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			$controller->main_menu = Home::getMainMenu($action);

			$controller->submenu_title = Yii::t('app', 'Liquidaciones');

            $controller->submenu = array(
            array('label' => Yii::t('app', 'Generar liquidación'), 'url' => array('/clearence'), 'active' => Home::isActive('/clearence')),
            array('label' => Yii::t('app', 'Historial'), 'url' => array('/clearence/list/history'), 'active' => Home::isActive('/clearence/list/history')),
            );

			return true;
		}
		else
			return false;
	}
}
