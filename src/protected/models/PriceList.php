<?php

Yii::import('application.models._base.BasePriceList');

class PriceList extends BasePriceList {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return array(
            'purchase' => array(self::HAS_MANY, 'Purchase', 'price_list_id'),
            'user_log' => array(self::BELONGS_TO, 'User', 'user_update_id'),
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
        );
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Lista de Precios', $n);
    }

    public function attributeLabels() {
//        return CMap::mergeArray(parent::attributeLabels(), array('user_update_id' => Yii::t('app', 'User|Users', 1)));
        return array(
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Empresa'),
            'brand' => Yii::t('app', 'Marca'),
            'model' => Yii::t('app', 'Modelo'),
            'locked_price' => Yii::t('app', 'Precio con operadora'),
            'unlocked_price' => Yii::t('app', 'Precio liberado'),
            'broken_price' => Yii::t('app', 'Precio roto'),
            'created_at' => Yii::t('app', 'Creado'),
            'updated_at' => Yii::t('app', 'Modificado'),
            'user_update_id' => Yii::t('app', 'Usuario'),
        );
    }

    /*
     * Truncate Table
     */

    public function truncateTable() {
        $this->getDbConnection()->createCommand()->truncateTable($this->tableName());
    }

    /**
     * Mantiene la base de datos de lista de precios con paridad en el webservice
     * gracias al atributo 'imeiws_name'
     * @param  string $imeiws_name Nombre del equipo en el webservice
     * @param  string $brand       Nombre de la marca en la lista de precios
     * @param  string $model       Nombre del modelo en la lista de precios
     */
    public function matchWithImeiWebservice($imeiws_name, $brand, $model) {
        // TODO: Lo que va aca adentro 26-06-2015
    }

    /**
     * Devuelve el AR si encuentra una coincidencia en Gifdictionari con el gifname
     * @param  string $gif_name nombre del equipo para GIF (marca y modelo en un solo campo)
     * @return PriceList AR  el precio (equipo) que encontro o null
     */
    public function getByGifName($gif_name)
    {
        $gif_dictionary_device = GifDictionary::model()->getParidadMasVotada($gif_name);

        if (!$gif_dictionary_device) {
            // No está en el diccionario
            return null;
        }

        // Busca el dispositivo en Pricelist
        return $this->getDevice(array('brand' => $gif_dictionary_device->brand, 'model' => $gif_dictionary_device->model));
    }

    /**
     * Devuelve el equipo de la lista de empresa de la empresa, si existe y sino de la lista de owner
     * @param  string $brand [description]
     * @param  string $model [description]
     * @return PriceList AR
     */
    public function getDevice($device)
    {
        if (count($this->findAllByAttributes(array('company_id' => Yii::app()->user->company_id)))) {
            // Tiene lista de precio
            return $this->findByAttributes(array('company_id' => Yii::app()->user->company_id, 'brand' => $device['brand'], 'model' => $device['model']));
        } else {
            // No tiene lista de precio
            return $this->findByAttributes(array('company_id' => Company::model()->findByAttributes(array('is_owner' => true))->id, 'brand' => $device['brand'], 'model' => $device['model']));
        }
        
    }

    public function search()
    {
        $criteria = parent::search()->getCriteria();

        return new CActiveDataProvider(
            $this,
            array(
                'criteria' => $criteria,
                'pagination'=>array(
                    'pageSize'=>30,
                ),
            )
        );
    }

    public function getBrands() {

        if (count($this->findAllByAttributes(array('company_id' => Yii::app()->user->company_id)))) {
            // Tiene lista de precio
            return $this->findAllByAttributes(array('company_id' => Yii::app()->user->company_id));
        } else {
            // No tiene lista de precio
            return $this->findAllByAttributes(array('company_id' => Company::model()->findByAttributes(array('is_owner' => true))->id));
        }
    }
}
