<?php

Yii::import('application.models._base.BaseCompany');

class Company extends BaseCompany
{
    public static function model($className = __CLASS__) 
    {
        return parent::model($className);
    }

    public function relations() 
    {
        return array(
        'purchases' => array(self::HAS_MANY, 'Purchase', 'company_id'),
        'dispatch_notes' => array(self::HAS_MANY, 'DispatchNote', 'company_id'),
        'points_of_sale' => array(self::HAS_MANY, 'PointOfSale', 'company_id'),
        'users' => array(self::HAS_MANY, 'User', 'company_id'),
        'purchase_statuses' => array(self::HAS_MANY, 'PurchaseStatus', 'company_id'),

        'user_log' => array(self::BELONGS_TO, 'User', 'user_update_id'),
        );
    }

    public function rules() 
    {
        return CMap::mergeArray(
            parent::rules(),
            array(
            array('mail', 'email'),
            array('cuit', 'length', 'is' => 11),
            array(
            'cuit', 'numerical',
            'integerOnly' => true,
            ),
            )
        );
    }

    public static function label($n = 1) 
    {
        return Yii::t('app', 'Empresa|Empresas', $n);
    }

    public function attributeLabels() 
    {
        return CMap::mergeArray(
            parent::attributeLabels(),
            array(
                'user_update_id' => Yii::t('app', 'Usuario'),
                'social_reason' => Yii::t('app', 'Razón Social'),
                'company_code' => Yii::t('app', 'Código de Empresa'),
                'cuit' => Yii::t('app', 'C.U.I.T.'),
                'name' => Yii::t('app', 'Nombre'),
                'address' => Yii::t('app', 'Dirección'),
                'province' => Yii::t('app', 'Provincia'),
                'locality' => Yii::t('app', 'Localidad'),
                'phone' => Yii::t('app', 'Teléfono'),
                'percent_fee' => Yii::t('app', 'Comisión'),
            )
        );
    }

    public static function representingColumn() 
    {
        return 'social_reason';
    }

    public function getContractNumber() 
    {
        $last_contract = new ContractNumber();

        return $last_contract->getContractNumber();

        // $this->last_contract_number++;

        // if (!$this->save()){
        // 	//die(var_dump($this->getErrors()));
        // }

        // return $this->last_contract_number;

    }

    public function getDispatchNoteNumber() 
    {
        $this->last_dispatch_note_number++;

        if (!$this->save()) {
            //die(var_dump($this->getErrors()));
        }

        return $this->last_dispatch_note_number;

    }

    public function getHeadquarters() 
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('is_headquarter = :is_headquarter AND company_id = :company_id');
        // TODO: Descomentar esta linea que es la posta
        $criteria->addCondition('is_headquarter = :is_headquarter AND is_owner', 'OR');
        $criteria->params = array(':is_headquarter' => 1, ':company_id' => $this->id);

        $headquarters = PointOfSale::model()->findAll($criteria);

        return $headquarters;
    }

}