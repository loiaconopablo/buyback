<?php
class Home
{
    public static function getRoleHome()
    {
        /*
        Si es super usuario va al admin de los operadores
         */
        if (Yii::app()->user->checkAccess('superuser')) {
            return array('/admin_root/carrier/admin');
        }

        /*
        Si es administrador (BGH) va al controler purchase
         */
        if (Yii::app()->user->checkAccess('admin')) {
            return array('/purchase/list/inpointofsale');
        }

        if (Yii::app()->user->checkAccess('retail')) {
                return array('/purchase/buy/imei');
        }
        
        if (Yii::app()->user->checkAccess('technical_supervisor')) {
                return array('/purchase/list/insupervision');
        }

        //Si no esta logueado o no se reconoce el rol
        return array('/login');

    }

    public static function getMainMenu($action = null)
    {
        // Si no esta logueado lo mando a freir churros
        if (Yii::app()->user->isGuest) {
            return false;
        }

        /**
        * SETEO EL SUBTITULO DE LA SECCION
        */
        Yii::app()->controller->submenu_title = Yii::t('app', Yii::app()->user->company_name . ' / ' . Yii::app()->user->point_of_sale_name);

        /**
        * MENU DE SUPER USUARIO
        */
        if (Yii::app()->user->checkAccess('superuser')) {
            return array(
            array('label'=>Yii::t('app', 'Setup'), 'url'=>array('/admin_root/carrier/admin'), 'active' => Yii::app()->controller->id == 'carrier'),
            array('label'=>Yii::t('app', 'Roles'), 'url'=>array('/rights/authassignment/admin'), 'active' => Yii::app()->controller->id == 'authassignment'),
            array('label'=>Yii::t('app', 'Manage'), 'url'=>array('/admin/pointofsale/admin'), 'active' => Yii::app()->controller->module->id == 'admin'),
            );
        }

        /**
        * MENU DE ADMINISTRADOR BGH
        */
        if (Yii::app()->user->checkAccess('admin')) {
            return array(
            array('label'=>Yii::t('app', 'Equipos'), 'url'=>array('/purchase/list/inpointofsale'), 'active' => self::isActive('/purchase/list/inpointofsale')),
            array('label'=>Yii::t('app', 'Notas de envío'), 'url'=>array('/dispatchnote/list/pending'), 'active' => (Yii::app()->controller->module->id == 'dispatchnote')),
            array('label'=>Yii::t('app', 'Reportes'), 'url'=>array('/report'), 'active' => Yii::app()->controller->module->id == 'report'),
            array('label'=>Yii::t('app', 'Administración'), 'url'=>array('/admin/pointofsale/admin'), 'active' => Yii::app()->controller->module->id == 'admin'),
            );
        }

         /**
        * MENU DE SUPERVISOR TECNICO BGH
        */
        if (Yii::app()->user->checkAccess('technical_supervisor')) {
            return array(
            array('label'=>Yii::t('app', 'Equipos'), 'url'=>array('/purchase/list/insupervision'), 'active' => self::isActive('/purchase/list/inpointofsale')),
            array('label'=>Yii::t('app', 'Notas de envío'), 'url'=>array('/dispatchnote/list/pending'), 'active' => (Yii::app()->controller->module->id == 'dispatchnote')),
            array('label'=>Yii::t('app', 'Reportes'), 'url'=>array('/report'), 'active' => Yii::app()->controller->module->id == 'report'),
            );
        }

        /**
        * MENU DE RETAIL Y HEADQUARTER
        */
        if (Yii::app()->user->checkAccess('retail')) {
            return array(
                array('label'=>Yii::t('app', 'Inicio'), 'url'=>array('/purchase/buy/imei'), 'active' => false),
                array('label'=>Yii::t('app', 'Equipos'), 'url'=>array('/purchase/list/inpointofsale'), 'active' => self::isActive('/purchase/list/inpointofsale')),
                array('label'=>Yii::t('app', 'Notas de envío'), 'url'=>array('/dispatchnote/list/pending'), 'active' => (Yii::app()->controller->module->id == 'dispatchnote')),
            );
        }
    }

    public static function userMenu()
    {
        $menu_options = array();

        array_push($menu_options, array('label' => Yii::t('app', 'Cambiar contraseña'), 'url' => array('/auth/auth/changepassword','id'=>Yii::app()->user->id)));
        array_push($menu_options, TbHtml::menuDivider());
        array_push($menu_options, array('label' => Yii::t('app', 'Español'), 'url' => array(Yii::app()->request->getPathInfo().'?lang=es')));
        array_push($menu_options, array('label' => Yii::t('app', 'Português'), 'url' => array(Yii::app()->request->getPathInfo().'?lang=pt')));
        array_push($menu_options, TbHtml::menuDivider());
        array_push($menu_options, array('label' => Yii::t('app', 'Cerrar sesión'), 'url' => array('/auth/auth/logout')));

        return $menu_options;
                            
    }

    public static function isActive($url)
    {
        if (Yii::app()->request->url == Yii::app()->createUrl($url)) {
            return true;
        } else {
            return false;
        }
    }
}
