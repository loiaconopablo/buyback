<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class MonthlyForm extends CFormModel
{
    public $month;
    public $year;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
        
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
        'month' => Yii::t('app', 'Month'),
        'year' => Yii::t('app', 'Year'),
        );
    }

    /**
     * Devuelve un array de todos los años con registros activos
     * @return array Para popular DropdownList
     */
    public function getYearsList()
    {
        $model = new Purchase;
        $criteria = new CDbCriteria;
        //$criteria->select = 'YEAR(created_at) AS year';
        $criteria->group = 'YEAR(created_at)';
        $criteria->order = 'YEAR(created_at) DESC';

        $years = array();
        foreach ($model->findAll($criteria) as $purchase) {
            array_push($years, array('year' => date('Y', strtotime($purchase->created_at)))); 
        }

        return $years;
    }
}
