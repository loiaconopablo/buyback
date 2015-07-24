<?php

class DispatchnoteController extends Controller
{


    public function actionIndex() 
    {
        $this->redirect(array('admin'));
    }

    public function actionExpecting()
    {
        $model = new DispatchNote('search');
        $model->unsetAttributes();

        if (isset($_GET['DispatchNote'])) {
            $model->setAttributes($_GET['DispatchNote']);
        }

        $this->render(
            'admin _expecting', array(
            'model' => $model,
            )
        );
    }

    public function actionHistoryOthers() 
    {
        $model = new DispatchNote('search');
        $model->unsetAttributes();

        if (isset($_GET['DispatchNote'])) {
            $model->setAttributes($_GET['DispatchNote']);
        }

        $this->render(
            'admin_history_others', array(
            'model' => $model,
            )
        );
    }
    
    public function actionReport()
    {
        $model = new DispatchNote('search');
        $model->unsetAttributes();

        if (isset($_GET['DispatchNote'])) {
            $model->setAttributes($_GET['DispatchNote']);
        }

        $this->render(
            'dispatch_note_report', array(
            'model' => $model,
            )
        );
    }
}
