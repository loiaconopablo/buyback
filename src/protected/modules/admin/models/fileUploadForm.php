<?php

class fileUploadForm extends CFormModel {

    public $file;

    public function rules() {
        return array(
            array('file', 'file', 'types' => 'xlsx, xls', 'wrongType' => Yii::t('app', 'Tipo de archivo inválido')),
        );
    }
    
    public function attributeLabels() {
        return CMap::mergeArray(parent::attributeLabels(), array(
                    'file' => Yii::t('app', 'Archivo'),
        ));
    }

}
