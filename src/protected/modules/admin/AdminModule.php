<?php

class AdminModule extends CWebModule
{
    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(
            array(
            'admin.models.*',
            'admin.components.*',
            )
        );
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here

            // Si no es admin no lo deja ejecutar acciones en este modulo
            // Lo redirecciona a la pagina de login
            if(!Yii::app()->user->checkAccess('admin')) {
                $controller->redirect(Yii::app()->user->loginUrl);
            }

            if(Yii::app()->user->isGuest) { return false; 
            }

            $controller->main_menu = Home::getMainMenu();
            
            $controller->submenu_title = Yii::t('app', 'Admin');

            $controller->submenu = array(
            array('label'=>Yii::t('app', 'Empresas', 2), 'url'=>array('/admin/company'), 'active' =>  Yii::app()->controller->id=='company'),
            array('label'=>Yii::t('app', 'Puntos de venta'), 'url'=>array('/admin/pointofsale'), 'active' =>  Yii::app()->controller->id=='pointofsale'),
            array('label'=>Yii::t('app', 'Usuarios'), 'url'=>array('/admin/user/'), 'active' =>  Yii::app()->controller->id=='user'),
            array('label'=>Yii::t('app', 'Lista de precios', 2), 'url'=>array('/admin/pricelist'), 'active' =>  Yii::app()->controller->id=='pricelist'),
            array('label'=>Yii::t('app', 'Lista de códigos', 2), 'url'=>array('/admin/sellingcode'), 'active' =>  Yii::app()->controller->id=='sellingcode'),
            array('label'=>Yii::t('app', 'Forecast', 2), 'url'=>array('/admin/forecast/admin'), 'active' =>  Yii::app()->controller->id=='forecast'),
            );

            return true;
        }
        else {
            return false; 
        }
    }
}
