<?php

class PurchaseController extends Controller
{
    /**
    * action
    */
    public function actionView($id)
    {
        $this->renderPartial(
            'view', array(
            'model' => Purchase::model()->findByPk($id),
            )
        );
    }

    /**
    * action
    */
    public function actionOwnerView($id)
    {
        $this->renderPartial(
            'owner-view', array(
            'model' => Purchase::model()->findByPk($id),
            )
        );
    }

    /**
    * action
    */
    public function actionCancel($id)
    {
        Purchase::model()->findByPk($id)->setAsCancelled();
    }

    /**
    *
    */
    public function actionSetInObservation($id)
    {
        var_dump($_POST);
        return true;
    }
}