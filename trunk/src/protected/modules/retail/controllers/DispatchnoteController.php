<?php

class DispatchnoteController extends Controller
{

    public function actionIndex() 
    {
        $this->redirect(array('admin'));
    }

    /**
     * Lista los Nota de Envíos de a sucursal o cabecera
     */
    public function actionAdmin() 
    {
        $model = new DispatchNote('search');
        $model->unsetAttributes();

        $model->status = DispatchNote::PENDING_TO_SEND;

        if (isset($_GET['DispatchNote'])) {
            $model->setAttributes($_GET['DispatchNote']);
        }

        $this->render(
            'admin', array(
            'model' => $model,
            )
        );
    }

    public function actionHistory() 
    {
        $model = new DispatchNote('search');
        $model->unsetAttributes();

        if (isset($_GET['DispatchNote'])) {
            $model->setAttributes($_GET['DispatchNote']);
        }

        $this->render(
            'admin_history', array(
            'model' => $model,
            )
        );
    }
}