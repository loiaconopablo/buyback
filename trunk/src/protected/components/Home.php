<?php
class Home
{
	static public function getRoleHome()
	{
		if(Yii::app()->user->checkAccess('superuser')) {
			return array('/admin_root/carrier/admin');
		}

		if(Yii::app()->user->checkAccess('admin')) {
			return array('/admin/company/admin');
		}

		if(Yii::app()->user->checkAccess('retail')) {
			if (Yii::app()->user->is_headquarter) {
				return array('/headquarter');
			} else {
				return array('/retail');
			}
		}

		//Si no esta logueado o no se reconoce el rol
		return array('/login');

	}

	static public function getMainMenu($action = null)
	{
		// Si no esta logueado lo mando a freir churros
		if(Yii::app()->user->isGuest) {
			return false;
		}

		/**
		* SETEO EL SUBTITULO DE LA SECCION
		*/
		Yii::app()->controller->submenu_title = Yii::t('app', Yii::app()->user->company_name . ' / ' . Yii::app()->user->point_of_sale_name);

		/**
		* MENU DE SUPER USUARIO
		*/
		if(Yii::app()->user->checkAccess('superuser')) {
			return array(
					array('label'=>Yii::t('app', 'Setup'), 'url'=>array('/admin_root/carrier/admin'), 'active' => Yii::app()->controller->id == 'carrier'),
					array('label'=>Yii::t('app', 'Roles'), 'url'=>array('/rights/authassignment/admin'), 'active' => Yii::app()->controller->id == 'authassignment'),
					array('label'=>Yii::t('app', 'Manage'), 'url'=>array('/admin/pointofsale/admin'), 'active' => Yii::app()->controller->module->id == 'admin'),
				);
		}

		/**
		* MENU DE ADMINISTRADOR BGH
		*/
		if(Yii::app()->user->checkAccess('admin')) {
			return array(
					array('label'=>Yii::t('app', 'Equipos'), 'url'=>array('/owner/purchase/admin'), 'active' => Yii::app()->controller->id == 'purchase'),
					array('label'=>Yii::t('app', 'Notas de envío'), 'url'=>array('/owner/dispatchnote/expecting'), 'active' => Yii::app()->controller->id == 'dispatchnote'),
					array('label'=>Yii::t('app', 'Empresas'), 'url'=>array('/admin/pointofsale/admin'), 'active' => Yii::app()->controller->module->id == 'admin'),
				);
		}

		/**
		* MENU DE RETAIL Y HEADQUARTER
		*/
		if(Yii::app()->user->checkAccess('retail')) {
			if (Yii::app()->user->is_headquarter) {
				/**
				* MENU DE CABECEERA (HEADQUARTER)
				*/
				return array(
					array('label'=>Yii::t('app', 'Start'), 'url'=>array('/retail'), 'active' => false),
					array('label'=>Yii::t('app', 'Equipos'), 'url'=>array('/headquarter/admin/admin'), 'active' => self::isActive('/headquarter/admin/admin')),
					array('label'=>Yii::t('app', 'Notas de envío'), 'url'=>array('/headquarter/dispatchnote/admin'), 'active' => self::isActive('/headquarter/dispatchnote/admin')),
					array('label'=>Yii::t('app', 'Notas de envío pendientes'), 'url'=>array('/headquarter/dispatchnote/expecting'), 'active' => self::isActive('/headquarter/dispatchnote/expecting')),
					array('label'=>Yii::t('app', 'Historial Notas emitidas'), 'url'=>array('/headquarter/dispatchnote/historyown'), 'active' => self::isActive('/headquarter/dispatchnote/historyown')),
					array('label'=>Yii::t('app', 'Historial Notas recibidas'), 'url'=>array('/headquarter/dispatchnote/historyothers'), 'active' => self::isActive('/headquarter/dispatchnote/historyothers')),
				);
			} else {
				/**
				* MENU DE PUNTO DE VENTA (COMUN)
				*/
				return array(
					array('label'=>Yii::t('app', 'Start'), 'url'=>array('/retail'), 'active' => false),
					array('label'=>Yii::t('app', 'Equipos'), 'url'=>array('/retail/admin/admin'), 'active' => self::isActive('/retail/admin/admin')),
					array('label'=>Yii::t('app', 'Notas de envío'), 'url'=>array('/retail/dispatchnote/admin'), 'active' => self::isActive('/retail/dispatchnote/admin')),
					array('label'=>Yii::t('app', 'History'), 'url'=>array('/retail/dispatchnote/history'), 'active' => self::isActive('/retail/dispatchnote/history')),
				);
			}
		}
	}

	public static function userMenu()
	{
		$menu_options = array();

		array_push($menu_options, array('label' => Yii::t('app', 'Cambiar contraseña'), 'url' => array('/auth/auth/changepassword','id'=>Yii::app()->user->id)));
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