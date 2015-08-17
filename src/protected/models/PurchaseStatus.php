<?php

Yii::import('application.models._base.BasePurchaseStatus');

class PurchaseStatus extends BasePurchaseStatus
{
    public static function model($className=__CLASS__) 
    {
        return parent::model($className);
    }

    public function relations() 
    {
        return array(
        'purchase'         => array(self::BELONGS_TO, 'Purchase', 'purchase_id'),
        'status'           => array(self::BELONGS_TO, 'Status', 'status_id'),

        'point_of_sale'    => array(self::BELONGS_TO, 'PointOfSale', 'point_of_sale_id'),
        'company'          => array(self::BELONGS_TO, 'Company', 'company_id'),
        'headquarter'      => array(self::BELONGS_TO, 'PointOfSale', 'headquarter_id'),
        'dispatch_note'    => array(self::BELONGS_TO, 'DispatchNote', 'dispatch_note_id'),

        'user'             => array(self::BELONGS_TO, 'User', 'user_update_id'),
        );
    }

    public static function label($n = 1) 
    {
        return Yii::t('app', 'Purchase status|Purchase statuses', $n);
    }

    public function attributeLabels()
    {
        return CMap::mergeArray(parent::attributeLabels(), array(
            'user_update_id' => Yii::t('app', 'Usuario'),
            'status' => Yii::t('app', 'Estado'),
            'dispatch_note' => Yii::t('app', 'Nota de envío'),
            'point_of_sale' => Yii::t('app', 'Punto de venta'),
            'comment' => Yii::t('app', 'Comentario'),
        ));
    }
}