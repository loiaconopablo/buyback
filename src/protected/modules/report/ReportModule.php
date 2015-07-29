<?php

class ReportModule extends CWebModule
{

	public $defaultController = 'purchase';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'report.models.*',
			'report.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			if (Yii::app()->user->isGuest) {
                return false;
            }

            $controller->main_menu = Home::getMainMenu();

            $controller->submenu_title = Yii::t('app', 'Reportes');

            $controller->submenu = array(
            array('label' => Yii::t('app', 'Equipos', 2), 'url' => array('/report/purchase'), 'active' => $controller->id == 'purchase'),
            array('label' => Yii::t('app', 'Notas de envío', 2), 'url' => array('/report/dispatchnote'), 'active' => $controller->id == 'dispatchnote'),
            array('label' => Yii::t('app', 'Monthly'), 'url' => array('/report/purchase/monthly'), 'active' => $controller->id == 'monthly'),
            );

			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
