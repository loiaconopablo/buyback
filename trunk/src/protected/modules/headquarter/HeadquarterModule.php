<?php

class HeadquarterModule extends CWebModule
{
    public $defaultController = 'admin';

    public function init() 
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(
            array(
            'headquarter.models.*',
            'headquarter.components.*',
            )
        );
    }

    public function beforeControllerAction($controller, $action) 
    {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here

            // Ese metodo tambien setea el subtitulo de la seccion Ej. "Garbarino / Sucursal Primera Junta"
            $controller->main_menu = Home::getMainMenu();

            return true;
        } else {
            return false;
        }

    }
}
