<?php

Yii::import('application.models._base.BaseClearence');

class Clearence extends BaseClearence
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function relations() 
    {
        return array(
        	'purchases' => array(self::HAS_MANY, 'Purchase', 'clearence_id'),
        	'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
        );
    }

    public function attributeLabels() 
    {
        return CMap::mergeArray(
            parent::attributeLabels(),
            array(
                'user_update_id' => Yii::t('app', 'Usuario'),
                'user_create_id' => Yii::t('app', 'Usuario'),
                'company' => Yii::t('app', 'Empresa'),
                'total_purchase' => Yii::t('app', 'Total de compras rechazadas'),
                'total_paid' => Yii::t('app', 'Total aprobado'),
                'error_allowance' => Yii::t('app', 'Tolerancia de error'),
                'paid_comision' => Yii::t('app', 'Total comisión'),
            )
        );
    }
}