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
            array('label'=>Yii::t('app', 'Company|Companies', 2), 'url'=>array('/admin/company'), 'active' =>  Yii::app()->controller->id=='company'),
            array('label'=>Yii::t('app', 'Point of sale|Points of sale', 2), 'url'=>array('/admin/pointofsale'), 'active' =>  Yii::app()->controller->id=='pointofsale'),
            array('label'=>Yii::t('app', 'User|Users', 2), 'url'=>array('/admin/user/'), 'active' =>  Yii::app()->controller->id=='user'),
            array('label'=>Yii::t('app', 'Price|Price list', 2), 'url'=>array('/admin/pricelist'), 'active' =>  Yii::app()->controller->id=='pricelist'),
            );

            return true;
        }
        else {
            return false; 
        }
    }
}
