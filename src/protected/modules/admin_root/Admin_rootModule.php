<?php

class Admin_rootModule extends CWebModule
{
    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(
            array(
            'admin_root.models.*',
            'admin_root.components.*',
            )
        );

    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action)) {
            //$controller->layoutPath = Yii::getPathOfAlias('admin_root.views.layouts');
            // this method is called before any module controller action is performed
            // you may place customized code here

            // Si no es super user no lo deja ejecutar acciones en este modulo
            // Lo redirecciona a la pagina de login
            if(!Yii::app()->user->checkAccess('superuser')) {
                $controller->redirect(Yii::app()->user->loginUrl);
            }

            if(Yii::app()->user->isGuest) { return false; 
            }

            $controller->main_menu = Home::getMainMenu();
        
            $controller->submenu_title = Yii::t('app', 'Configuración');
            
            $controller->submenu = array(
            array('label'=>Yii::t('app', 'Estados', 2), 'url'=>array('/admin_root/status'), 'active' =>  Yii::app()->controller->id=='status'),
            array('label'=>Yii::t('app', 'Operadores', 2), 'url'=>array('/admin_root/carrier'), 'active' =>  Yii::app()->controller->id=='carrier'),
            array('label'=>Yii::t('app', 'Estados de equipo', 2), 'url'=>array('/admin_root/device_status'), 'active' =>  Yii::app()->controller->id=='device_status'),
            array('label'=>Yii::t('app', 'Migraciones'), 'url'=>array('/admin_root/migrations/run'), 'active' =>  Yii::app()->controller->id=='migrations'),
            );
            return true;
        }
        else {
            return false; 
        }
    }
}
