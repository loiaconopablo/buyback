<?php

class AdminController extends Controller
{

    public $layout='//layouts/column2';

    

    /**
    * action
    */
    public function actionIndex()
    {
        $this->redirect(array('admin'));
    }

    /**
     * Lista los equipos en el lugar listos para ser enviados a la cabecera
     */
    public function actionAdmin()
    {
        // Limpia la cookie de checkbox seleccionados en Grid
        // Para que esto funcione 'ajaxUpdate'=>true en el Grid de la vista
        if (!Yii::app()->request->isAjaxRequest) {
            unset(Yii::app()->request->cookies['checkedItems']);
        }

        $model = new Purchase;
        $model->unsetAttributes();

        if (isset($_GET['Purchase'])) {
            $model->setAttributes($_GET['Purchase']);
        }
        
        $this->render(
            'admin',
            array(
            'model' => $model,
            )
        );
    }
}
