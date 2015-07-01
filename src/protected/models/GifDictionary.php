<?php

Yii::import('application.models._base.BaseGifDictionary');

class GifDictionary extends BaseGifDictionary
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Busca el registro con name con la cantidad mas alta
     * @param  string $name Nombre del equipo con la nomenclatura de GIF
     * @return GifDictionary Devuelve el AR del registro que matchea con 'name' de mayor cantidad (si lo encuentra)
     */
    public function getParidadMasVotada($name)
    {
        $most_voted = $this->findByAttributes(array('name' => $name), array('order'=>'quantity DESC'));

        if (count($most_voted)) {
            return $most_voted;
        } else {
            return null;
        }
    }


    /**
     * Incrementa en 1 el campo 'quantity' del registro que coincde con name, brand, model
     * O crea el registro con name, brand, model, quantity = 1
     * @param  string $name  Nombre del dispositivo en GIF (GSM) (gif_dictionary)
     * @param  string $brand Nomenclatura de la marca para BGH (price_list)
     * @param  string $model Nomenclatura de la marca para BGH (price_list)
     * @return GifDictionary        AR del registro modificado o el creado
     */
    public function incrementQuantity($name, $brand, $model)
    {
        $device = $this->findByAttributes(array('name' => $name, 'brand' => $brand, 'model' => $model));

        if (count($device)) {
            // si el registro ya existe incrementa en 1 quantity
            $device->saveCounters(array('quantity' => 1));

            return $device;
        }

        // Si no encontro el registro
        // Crea uno nuevo
        $device = new GifDictionary;
        
        $device->name = $name;
        $device->brand = $brand;
        $device->model = $model;

        $device->save();

        return $device;
    }
}
