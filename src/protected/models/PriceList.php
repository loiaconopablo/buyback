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
        );
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Lista de Precios', $n);
    }

    public function attributeLabels() {
//        return CMap::mergeArray(parent::attributeLabels(), array('user_update_id' => Yii::t('app', 'User|Users', 1)));
        return array(
            'id' => Yii::t('app', 'ID'),
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
        return PriceList::model()->findByAttributes(array('brand' => $gif_dictionary_device->brand, 'model' => $gif_dictionary_device->model));
    }
}
