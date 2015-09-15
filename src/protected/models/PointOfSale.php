<?php

Yii::import('application.models._base.BasePointOfSale');

class PointOfSale extends BasePointOfSale {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return array(
            'purchases_headquarter' => array(self::HAS_MANY, 'Purchase', 'headquarter_id'),
            'purchases_point_of_sale' => array(self::HAS_MANY, 'Purchase', 'point_of_sale_id'),
            'purchases_last_location' => array(self::HAS_MANY, 'Purchase', 'last_location_id'),
            'dispatch_notes_source' => array(self::HAS_MANY, 'DispatchNote', 'source_id'),
            'dispatch_notes_destinantio' => array(self::HAS_MANY, 'DispatchNote', 'destination_id'),
            'users' => array(self::HAS_MANY, 'User', 'point_of_sale_id'),
            'purchases_status_point_of_sale' => array(self::HAS_MANY, 'PurchaseStatus', 'point_of_sale_id'),
            'purchases_status_headquarter' => array(self::HAS_MANY, 'PurchaseStatus', 'headquarter_id'),
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'headquarter' => array(self::BELONGS_TO, 'PointOfSale', 'headquarter_id'),
            'user_log' => array(self::BELONGS_TO, 'User', 'user_update_id'),
        );
    }

    public function rules() {
        return CMap::mergeArray(
                        parent::rules(), array(
                    array('headquarter_id', 'validateHeadquarter'),
                    array('mail', 'email'),
                    array('reference_mail', 'email'),
                    array('phone', 'match', 'pattern' => '/^([0-9-+])+$/'),
                    array('reference_phone', 'match', 'pattern' => '/^([0-9-+])+$/'),
        ));
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Puntos de venta', $n);
    }

    public function getHeadquartersByCompany($company_id) {
        $model = $this->findAllByAttributes(
                array(
            'company_id' => $company_id,
            'is_headquarter' => 1,
                ), array('order' => 'name ASC')
        );
        return $model;
    }

    public function getPointsOfSaleByCompany($company_id) {
        $model = $this->findAllByAttributes(
                array(
            'company_id' => $company_id,
                ), array('order' => 'name ASC')
        );

        return $model;
    }

    /**
     * Valida el atributo headquarter_id
     * Todos los puntos de venta (point_of_sale) obligatoriamente
     * Salvo que pertenezca a la empresa owner (BGH)
     * En este caso puede tener headquarter como no
     *
     * @param  string $attribute El nombre del atributo del modelo (headquarter_id)
     * @param  [type] $params    [description]
     * @return boolean           Devuelve TRUE si valida ok o un error
     */
    public function validateHeadquarter($attribute, $params) {

        if ($this->$attribute) {
            // Tiene un headquarter asiganado ya valida ok
            return true;
        }

        if ($this->company->is_owner && $this->is_headquarter) {
            // Pertenece a la empresa owner (BGH)
            return true;
        }

        // NO tiene headquarter asignado
        // NO pertenece a la empresa owner (BGH)
        // DEBE tener headquarter asignado (Propio o del owner)
        $this->addError($attribute, Yii::t('app', 'Debe seleccionar una cabecera'));
    }

    public function attributeLabels() {
        return CMap::mergeArray(
                        parent::attributeLabels(), array(
                    'user_update_id' => Yii::t('app', 'Usuario'),
                    'headquarter_id' => Yii::t('app', 'Cabecera'),
                    'name' => Yii::t('app', 'Nombre'),
                    'address' => Yii::t('app', 'Dirección'),
                    'province' => Yii::t('app', 'Provincia'),
                    'locality' => Yii::t('app', 'Localidad'),
                    'phone' => Yii::t('app', 'Teléfono'),
                    'company_id' => Yii::t('app', 'Empresa'),
                    'company' => Yii::t('app', 'Empresa'),
                    'reference_mail' => Yii::t('app', 'Mail Referencia'),
                    'is_headquarter' => Yii::t('app', 'Es Cabecera'),
                    'user_log' => Yii::t('app', 'Usuario'),
                    'reference_name' => Yii::t('app', 'Referencia'),
                    'reference_phone' => Yii::t('app', 'Telefono Referencia'),
                        )
        );
    }

    public function search() {
        $criteria = parent::search()->getCriteria();

        $criteria->select = 't.*';

        return new CActiveDataProvider(
                $this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
                )
        );
    }

}
