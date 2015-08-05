<?php

Yii::import('application.models._base.BaseForecast');

class Forecast extends BaseForecast
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function attributeLabels()
    {
        return CMap::mergeArray(
            parent::attributeLabels(),
            array(
            'user_update_id' => Yii::t('app', 'User|Users', 1),
            'user_create_id' => Yii::t('app', 'Usuario'),
            'month' => Yii::t('app', 'Mes'),
            'year' => Yii::t('app', 'Año'),
            'quantity' => Yii::t('app', 'Cantidad'),
            )
        );
    }

    /**
     * Devuelve la cantidad del forecast buscandolo por año y mes o 0 si no lo encuentra
     * @param  integer $year  Año
     * @param  integer $month Mes
     * @return integer La cantidad estimada para ese periododo
     */
    public function getForecastByYearMonth($year, $month)
    {
    	$criteria = new CDbCriteria;
        $criteria->addCondition('year = :year');
        $criteria->addCondition('month = :month');
        $criteria->params = array(
            ':year' => $year,
            ':month' => $month,
        );

    	$forecast = $this->find($criteria);

    	if (!count($forecast)) {
    		return 1;
    	} else {
    		return $forecast->quantity;
    	}
    }
}