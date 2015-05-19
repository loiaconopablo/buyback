<?php

Yii::import('application.models._base.BaseContractNumber');

class ContractNumber extends BaseContractNumber
{
    
    public static function model($className=__CLASS__) 
    {
        return parent::model($className);
    }

    public function getContractNumber()
    {
        $model = $this->findByPk(1);

        $model->last_contract_number++;

        if (!$model->save()) {
            //die(var_dump($model->getErrors()));
        }

        return $model->last_contract_number;
    }
}