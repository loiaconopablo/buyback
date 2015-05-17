<?php

Yii::import('application.models._base.BaseStatus');

class Status extends BaseStatus
{
    const PENDING                          = 10;
    const PENDING_TO_SEND                  = 20; //Ya esta en un remito
    const SENT                             = 30;
    const RECEIVED                         = 40;
    const PENDING_TO_BE_RECEIVED           = 50;
    const CANCELLED                        = 60;
    const IN_OBSERVATION                   = 70;
    const APPROVED                         = 80;
    const REJECTED                         = 90;
    const REQUOTED                         = 100;
    const PAID                             = 110;

    public static function model($className=__CLASS__) 
    {
        return parent::model($className);
    }

    public function relations() 
    {
        return array(
        'purchase_status'      => array(self::HAS_MANY, 'PurchaseStatus', 'status_id'),
        'current_status'       => array(self::HAS_MANY, 'Purchase', 'purchase_status_id'),
        'user_log'             => array(self::BELONGS_TO, 'User', 'user_update_id'),
        );
    }

    public function attributeLabels()
    {
        return CMap::mergeArray(parent::attributeLabels(), array('user_update_id' => Yii::t('app', 'User|Users', 1)));
    }
}