<?php

class OwnerModule extends CWebModule
{
    public $defaultController = 'dispatchnote';

    public function init() 
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(
            array(
            'owner.models.*',
            'owner.components.*',
            )
        );
    }

    public function beforeControllerAction($controller, $action) 
    {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here

            if (Yii::app()->user->isGuest) {
                return false;
            }

            $controller->main_menu = Home::getMainMenu();

            if (Yii::app()->controller->id == 'dispatchnote') {
                $controller->submenu_title = Yii::t('app', 'Notas de envío');

                $controller->submenu = array(
                array('label' => Yii::t('app', 'Pendientes', 2), 'url' => array('/owner/dispatchnote/expecting'), 'active' => Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'owner/dispatchnote/expecting'),
                array('label' => Yii::t('app', 'Historial', 2), 'url' => array('/owner/dispatchnote/historyothers'), 'active' => Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'owner/dispatchnote/historyothers'),
                );
            }

            if (Yii::app()->controller->id == 'purchase') {
                $controller->submenu_title = Yii::t('app', 'Notas de envío');

                $controller->submenu = array(
                array('label' => Yii::t('app', 'Recibidos'), 'url' => array('/owner/purchase/admin'), 'active' => Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'owner/purchase/admin'),
                array('label' => Yii::t('app', 'En observación'), 'url' => array('/owner/purchase/inobservation'), 'active' => Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'owner/purchase/inobservation'),
                array('label' => Yii::t('app', 'Para liquidar'), 'url' => array('/owner/purchase/topay'), 'active' => Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'owner/purchase/topay'),
                array('label' => Yii::t('app', 'Historial'), 'url' => array('/owner/purchase/history'), 'active' => Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'owner/purchase/history'),
                );
            }

            return true;
        } else {
            return false;
        }

    }
}
