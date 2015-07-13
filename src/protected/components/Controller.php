<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column2.view';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * Habilita la busqueda avanzada si es TRUE
     * @var boolean
     */
    public $advanced_search = false;
    /**
     * Habilita el cuadro de referencia de estados de los equipos si es TRUE
     * @var boolean
     */
    public $purchase_references = false;
    /**
     * Habilita el filtro entre fechas si es TRUE
     * @var boolean
     */
    public $date_filter = false;

    public $main_menu = array();
    public $submenu = array();
    public $submenu_title = '';
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    protected function beforeAction($action)
    {
        if (!Yii::app()->user->isGuest) {
            if ($this->conditionForChangePassword(Yii::app()->user->id) && !($action->controller->id == 'auth' or $action->id == 'error')) {
                $this->redirect(array('/auth/auth/changepassword', 'id' => Yii::app()->user->id));
            }

        } else {
            if (($action->id != 'login') && ($action->id != 'error')) {
                $this->redirect(array('/login'));
            }
        }
        return parent::beforeAction($action);
    }

    protected function conditionForChangePassword($id)
    {

        $model = new User;

        $model = User::model()->findByAttributes(array('id' => $id));

        if (!$model->is_password_validated) {
            return true;
        }

        return false;
    }
}
