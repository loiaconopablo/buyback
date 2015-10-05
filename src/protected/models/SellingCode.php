<?php

Yii::import('application.models._base.BaseSellingCode');

class SellingCode extends BaseSellingCode {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Lista de códigos', $n);
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'brand' => Yii::t('app', 'Marca'),
            'model' => Yii::t('app', 'Modelo'),
            'movistar_a' => Yii::t('app', 'Movistar A'),
            'personal_a' => Yii::t('app', 'Personal A'),
            'claro_a' => Yii::t('app', 'Claro A'),
            'libre_a' => Yii::t('app', 'Libre A'),
            'movistar_b' => Yii::t('app', 'Movistar B'),
            'personal_b' => Yii::t('app', 'Personal B'),
            'claro_b' => Yii::t('app', 'Claro B'),
            'libre_b' => Yii::t('app', 'Libre B'),
            'bad_refurbish' => Yii::t('app', 'BAD Refabricado'),
            'bad_irreparable' => Yii::t('app', 'BAD Irreparable'),
        );
    }

    public function rules() {
        return CMap::mergeArray(
                        parent::rules(), array(
                    array('movistar_a', 'match', 'pattern' => '/^PNT-+.*[A-Z\d]+$/', 'message' => Yii::t('app', 'El formato es invalido.')),
                    array('personal_a', 'match', 'pattern' => '/^PNT-+.*[A-Z\d]+$/', 'message' => Yii::t('app', 'El formato es invalido')),
                    array('claro_a', 'match', 'pattern' => '/^PNT-+.*[A-Z\d]+$/', 'message' => Yii::t('app', 'El formato es invalido')),
                    array('libre_a', 'match', 'pattern' => '/^PNT-+.*[A-Z\d]+$/', 'message' => Yii::t('app', 'El formato es invalido')),
                    array('movistar_b', 'match', 'pattern' => '/^PNT-+.*[A-Z\d]+$/', 'message' => Yii::t('app', 'El formato es invalido')),
                    array('personal_b', 'match', 'pattern' => '/^PNT-+.*[A-Z\d]+$/', 'message' => Yii::t('app', 'El formato es invalido')),
                    array('claro_b', 'match', 'pattern' => '/^PNT-+.*[A-Z\d]+$/', 'message' => Yii::t('app', 'El formato es invalido')),
                    array('libre_b', 'match', 'pattern' => '/^PNT-+.*[A-Z\d]+$/', 'message' => Yii::t('app', 'El formato es invalido')),
                    array('bad_refurbish', 'match', 'pattern' => '/^PNT-+.*[A-Z\d]+$/', 'message' => Yii::t('app', 'El formato es invalido')),
                    array('bad_irreparable', 'match', 'pattern' => '/^PNT-+.*[A-Z\d]+$/', 'message' => Yii::t('app', 'El formato es invalido')),
        ));
    }

    public function search() {
        $criteria = parent::search()->getCriteria();

        return new CActiveDataProvider(
                $this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 30)));
    }

    public function truncate() {
        $this->getDbConnection()->createCommand()->truncateTable($this->tableName());
    }

}
