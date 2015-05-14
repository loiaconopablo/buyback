<?php

class MigrationsController extends Controller {

	public function actionRun() 
	{
	    $this->runMigrationTool();
	}

	private function runMigrationTool() 
	{
	    $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
	    $runner = new CConsoleCommandRunner();
	    $runner->addCommands($commandPath);
	    $commandPath = Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';
	    $runner->addCommands($commandPath);
	    $args = array('yiic', 'migrate', '--interactive=0');
	    ob_start();
	    $runner->run($args);
	    echo htmlentities(ob_get_clean(), null, Yii::app()->charset);
	}

	/**
	* Este metodo lo usamos para arreglar los numeros de contrato que no guardaban el punto de venta
	* 14/05/2015
	*/
	// public function actionUpdatePurchaseContractNumber()
	// {
	// 	$model = new Purchase();

	// 	$model = $model->findAll('cae_response_json <> "Este es un CAI fijo temporal mientras se tramita el CAE"');

	// 	foreach ($model as $purchase) {

	// 		$contract_pdv_num = str_pad(124, 4, "0", STR_PAD_LEFT);
	// 		$contract_cn_num = str_pad($purchase->contract_number, 8, "0", STR_PAD_LEFT);
	// 		$final_contract_number = $contract_pdv_num . '-' . $contract_cn_num;

	// 		$purchase->contract_number = $final_contract_number;

	// 		$purchase->save();
	// 	}
	// }
}