<?php

class multiCreateForm extends CFormModel {

    public $file;
    public $company_id;
    public $headquarter_id;

    public function rules() {
        return array(
            array('company_id', 'required'),
            array('headquarter_id', 'required'),
            array('file', 'file', 'types' => 'xlsx, xls', 'wrongType' => Yii::t('app', 'Tipo de archivo inválido')),
        );
    }

    public function attributeLabels() {
        return CMap::mergeArray(parent::attributeLabels(), array(
                    'headquarter_id' => Yii::t('app', 'Cabecera'),
                    'company_id' => Yii::t('app', 'Empresa'),
                    'file' => Yii::t('app', 'Archivo'),
        ));
    }

    public function relations() {
        return array(
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'headquarter' => array(self::BELONGS_TO, 'PointOfSale', 'headquarter_id'),
        );
    }

}
