<?php $this->renderPartial('uncontract', array('model' => $model, 'carrier_name' => $carrier_name, 'contract_number' => $contract_number, 'footer' => 'Original para BGH'));?>
<?php $this->renderPartial('uncontract', array('model' => $model, 'carrier_name' => $carrier_name, 'contract_number' => $contract_number, 'footer' => 'Duplicado para la Sucursal'));?>
<?php $this->renderPartial('uncontract', array('model' => $model, 'carrier_name' => $carrier_name, 'contract_number' => $contract_number, 'footer' => 'Triplicado para el Cliente'));
