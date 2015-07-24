<?php

Yii::import('application.models._base.BaseCounters');

class Counters extends BaseCounters
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}


	public function getNext($id)
    {
        $model = $this->findByPk($id);

        $model->quantity++;

        try {

        	if ($model->save()) {
        		return $model->quantity;
        	}

        } catch (Exception $e) {
        	throw $e;
        }

        return false;
    }
}