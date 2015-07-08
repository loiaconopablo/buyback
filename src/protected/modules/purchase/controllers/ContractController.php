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
                'expression' => "Yii::app()->user->checkAccess('retail')",
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
        $purchase = Purchase::model()->findByPk($purchase_id);
        $retail = PointOfSale::model()->findByPk($purchase->point_of_sale_id);
        $seller = Seller::model()->findByPk($purchase->seller_id);

        $carrier = Carrier::model()->findByPk($purchase->carrier_id);

        if (!$carrier) {
            $carrier_name = Yii::t('app', 'Unlocked');
        } else {
            $carrier_name = $carrier->name;
        }

        //$this->renderPartial('contract', array('model' => $purchase, 'retail' => $retail, 'seller' => $seller, 'carrier_name' => $carrier_name));
        //die();

        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->WriteHTML($this->renderPartial('contract_wrap_pdf', array('model' => $purchase, 'retail' => $retail, 'seller' => $seller, 'carrier_name' => $carrier_name), true));
        $html2pdf->Output();
    }

    // public function actionGenerateUnContract($purchase_id)
    // {
    //     if (!Yii::app()->user->checkAccess('admin')) {
    //         return false;
    //     }

    //     $purchase = Purchase::model()->findByPk($purchase_id);
    //     $retail = PointOfSale::model()->findByPk($purchase->point_of_sale_id);
    //     $seller = Seller::model()->findByPk($purchase->seller_id);

    //     $carrier = Carrier::model()->findByPk($purchase->carrier_id);

    //     try {
    //         /**
    //          * Array con la respuesta de la AFIP con los siguienes items
    //          * ['contract_munber'] : integer
    //          * ['cae'] : integer
    //          * ['json_response'] : string : json raw del json que devuelve la afip con todos sus datos incluido el CAE
    //          *
    //          * @var array
    //          */
    //         $cae_array = Yii::app()->wsfe->getCaeParaContrato($purchase->purchase_price, $seller);

    //     } catch (Exception $e) {
    //         Yii::app()->user->setFlash('error', $e);

    //         return;

    //     }

    //     if (!$carrier) {
    //         $carrier_name = Yii::t('app', 'Unlocked');
    //     } else {
    //         $carrier_name = $carrier->name;
    //     }

    //     //$this->renderPartial('contract', array('model' => $purchase, 'retail' => $retail, 'seller' => $seller, 'carrier_name' => $carrier_name));
    //     //die();

    //     $html2pdf = Yii::app()->ePdf->HTML2PDF();
    //     $html2pdf->WriteHTML($this->renderPartial('uncontract_wrap', array('model' => $purchase, 'retail' => $retail, 'seller' => $seller, 'carrier_name' => $carrier_name, 'contract_number' => $cae_array['contract_number']), true));
    //     $html2pdf->Output();
    // }

   
}
