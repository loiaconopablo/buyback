<?php

class DispatchnoteModule extends CWebModule
{
    public $defaultController = 'dispatchnote';

    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(
            array(
            'dispatchnote.models.*',
            'dispatchnote.components.*',
            )
        );
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            
            // Ese metodo tambien setea el subtitulo de la seccion Ej. "Garbarino / Sucursal Primera Junta"
            $controller->main_menu = Home::getMainMenu();

           $controller->submenu_title = Yii::t('app', 'Notas de envío');

            $controller->submenu = array(
                array('label' => Yii::t('app', 'Por enviar', 2), 'url' => array('list/pending'), 'active' => Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'dispatchnote/list/pending'),
                array('label' => Yii::t('app', 'Por recibir', 2), 'url' => array('list/expecting'), 'active' => Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'dispatchnote/list/expecting', 'disabled' => !Yii::app()->user->is_headquarter),
                array('label' => Yii::t('app', 'Todas', 2), 'url' => array('list/history'), 'active' => Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'dispatchnote/list/history'),
            );

            return true;
        }
        else {
            return false; 
        }
    }
}
