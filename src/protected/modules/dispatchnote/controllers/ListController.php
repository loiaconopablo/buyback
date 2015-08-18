<?php

class ListController extends Controller
{


    public function actionPending() 
    {
        $model = new DispatchNote('search');
        $model->unsetAttributes();

        if (isset($_GET['DispatchNote'])) {
            $model->setAttributes($_GET['DispatchNote']);
        }

        Helper::pushInCookie(DispatchNote::PENDING_TO_SEND, 'checkedDispatchnoteStatuses');

        $this->render(
            'pending', array(
            'model' => $model,
            )
        );
    }

    public function actionExpecting()
    {
        $model = new DispatchNote('search');
        $model->unsetAttributes();

        if (isset($_GET['DispatchNote'])) {
            $model->setAttributes($_GET['DispatchNote']);
        }

        Helper::pushInCookie(DispatchNote::SENT, 'checkedDispatchnoteStatuses');
        Helper::pushInCookie(DispatchNote::PARTIALLY_RECEIVED, 'checkedDispatchnoteStatuses');

        $this->render(
            'expecting', array(
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
            'history', array(
            'model' => $model,
            )
        );
    }
}
