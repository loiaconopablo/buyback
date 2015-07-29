<?php

class ContractController extends Controller
{

    /**
    * @return array action filters
    */
    public function filters()
    {
            return array(
                    'accessControl', // perform access control for CRUD operations
            );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('generate'),
                'expression' => "Yii::app()->user->checkAccess('retail') || Yii::app()->user->checkAccess('admin')",
            ),
            array(
                'allow',
                'actions' => array('generatecancellationcontract'),
                'expression' => "Yii::app()->user->checkAccess('admin')",
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

   
    /**
     * Genera el contrato por triplicado en PDF
     * @param  integer $purchase_id Purchase.id
     */
    public function actionGenerate($purchase_id)
    {
        $this->layout = false;
        $purchase = Purchase::model()->findByPk($purchase_id);

        // No permite imprimir contrato si no es el dueño o administrador
        if ($this->isOwner($purchase) || Yii::app()->user->checkAccess('admin')) {

            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->WriteHTML($this->renderPartial('contract_wrap_pdf', array('model' => $purchase), true));
            $html2pdf->Output(Yii::t('app', 'contrato_' . $purchase->contract_number . '.pdf'));
            
        }

        Yii::app()->end();

    }

    /**
     * Genera el contrato en PDF de cancelación
     * @param  integer $purchase_id Purchase.id
     */
    public function actionGenerateCancellationContract($purchase_id)
    {

        $purchase = Purchase::model()->findByPk($purchase_id);

        // No es una nota de crédito
        if($purchase->comprobante_tipo != 'NC') {
            Yii::app()->end();
        }

        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->WriteHTML($this->renderPartial('cancellation_wrap_pdf', array('model' => $purchase), true));
        $html2pdf->Output(Yii::t('app', 'anulacion_' . $purchase->contract_number . '.pdf'));

    }
    /**
     * @param  integer Purchase AR
     * @return boolean
     */
   public function isOwner($purchase)
   {
        return ($purchase->point_of_sale_id == Yii::app()->user->point_of_sale_id);
   }
}
