<?php
$contract_pdv_num = str_pad(WsfeClient::PUNTO_DE_VENTA, 4, "0", STR_PAD_LEFT);
$contract_cn_num = str_pad($model->contract_number, 8, "0", STR_PAD_LEFT);
$final_contract_number = $contract_pdv_num . '-' . $contract_cn_num;

$model->contract_number = $final_contract_number;
?>
<?php $this->renderPartial('contract', array('model' => $model, 'carrier_name' => $carrier_name, 'footer' => 'Original para BGH'));?>
<?php $this->renderPartial('contract', array('model' => $model, 'carrier_name' => $carrier_name, 'footer' => 'Duplicado para la Sucursal'));?>
<?php $this->renderPartial('contract', array('model' => $model, 'carrier_name' => $carrier_name, 'footer' => 'Triplicado para el Cliente'));?>