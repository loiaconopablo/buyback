<?php

class PurchaseController extends Controller
{
	public function accessRules() {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('clear', 'view'),
                'expression' => "Yii::app()->user->checkAccess('admin')",
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

	public function actionClear($id) 
    {
        $model = new Purchase('search');
        $model->unsetAttributes();

        $model_rows = $model->findAllByAttributes(array('last_dispatch_note_id' => $id));

        $total_rejected_price = 0;
        $total_paid_price = 0;
        $total_comision = 0;


        foreach ($model_rows as $key => $purchase) {
            if ($purchase->current_status_id == Status::APPROVED) {
                $total_paid_price += $purchase->paid_price;
            }

            if ($purchase->current_status_id == Status::REQUOTED) {
                $total_paid_price += $purchase->paid_price;
            }

            if ($purchase->current_status_id == Status::REJECTED) {
                $total_rejected_price += $purchase->purchase_price;
            }

            $total_comision += round($purchase->paid_price * ($purchase->company->percent_fee / 100), 2);
        }

        $total_paid_price = round($total_paid_price, 2);
        $total_rejected_price = round($total_rejected_price, 2);

        $error_allowance = round(($total_paid_price + $total_rejected_price) * 0.03, 2);

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            // Guarda la liquidacion
            
            $liquidacion = new Clearence();

            $liquidacion->company_id = $purchase->company->id;
            $liquidacion->total_purchase = $total_rejected_price;
            $liquidacion->total_paid = $total_paid_price;
            $liquidacion->error_allowance = $error_allowance;
            $liquidacion->paid_comision = $total_comision;
            $liquidacion->total_comision = $total_comision + $error_allowance;

            $transaction = Yii::app()->db->beginTransaction();

            if ($liquidacion->save()) {
                $liquidacion->refresh();

                try {
                    foreach ($model_rows as $key => $purchase) {
                        $purchase->clearence_id = $liquidacion->id;
                        $purchase->setStatus(Status::PAID, $purchase->last_dispatch_note_id);
                    }
                } catch (Exception $e) {
                    $transaction->rollback;
                    throw $e;
                }
                
                $transaction->commit();

            } else {
                $liquidacion->getErrors();
                $transaction->rollback();
                die();
            }

        }


        $this->render(
            'clear', array(
                'model' => $model,
                'dispatchnote_id' => $id,
                'total_paid_price' => $total_paid_price,
                'total_comision' => $total_comision,
                'total_rejected_price' => $total_rejected_price,
                'error_allowance' => $error_allowance,
            )
        );
    }

    /**
     * Muestra la liquidacion
     */
    public function actionView($id)
    {
        $clearence = Clearence::model()->findByPk($id);

        $purchases = Purchase::model()->findAllByAttributes(array('clearence_id' => $id));

        $dataProvider = new CActiveDataProvider('Purchase');
        $dataProvider->setData($purchases);

        $this->render(
            'view', array(
                'model' => $purchases,
                'dataProvider' => $dataProvider,
                'total_paid_price' => $clearence->total_paid,
                'total_comision' => $clearence->paid_comision,
                'total_rejected_price' => $clearence->total_purchase,
                'error_allowance' => $clearence->error_allowance,
            )
        );
    }
}