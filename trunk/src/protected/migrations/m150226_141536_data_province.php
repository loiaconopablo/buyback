<?php

class m150226_141536_data_province extends CDbMigration
{
    public function up()
    {
        
        $i=0;
        $sql = 'SET foreign_key_checks = 0';
        Yii::app()->db->createCommand($sql)->execute();
        $sql = 'SET foreign_key_checks = 1';
        Try{

            /* Dumpling Structure for province*/

            $i++;
            $toInsert[$i]['id'] = '1'; 
            $toInsert[$i]['name'] = 'Ciudad Autonoma de Buenos Aires'; 

            $i++;
            $toInsert[$i]['id'] = '2'; 
            $toInsert[$i]['name'] = 'Buenos Aires'; 

            $i++;
            $toInsert[$i]['id'] = '3'; 
            $toInsert[$i]['name'] = 'Catamarca'; 

            $i++;
            $toInsert[$i]['id'] = '4'; 
            $toInsert[$i]['name'] = 'Chaco'; 

            $i++;
            $toInsert[$i]['id'] = '5'; 
            $toInsert[$i]['name'] = 'Chubut'; 

            $i++;
            $toInsert[$i]['id'] = '6'; 
            $toInsert[$i]['name'] = 'Córdoba'; 

            $i++;
            $toInsert[$i]['id'] = '7'; 
            $toInsert[$i]['name'] = 'Corrientes'; 

            $i++;
            $toInsert[$i]['id'] = '8'; 
            $toInsert[$i]['name'] = 'Entre Ríos'; 

            $i++;
            $toInsert[$i]['id'] = '9'; 
            $toInsert[$i]['name'] = 'Formosa'; 

            $i++;
            $toInsert[$i]['id'] = '10'; 
            $toInsert[$i]['name'] = 'Jujuy'; 

            $i++;
            $toInsert[$i]['id'] = '11'; 
            $toInsert[$i]['name'] = 'La Pampa'; 

            $i++;
            $toInsert[$i]['id'] = '12'; 
            $toInsert[$i]['name'] = 'La Rioja'; 

            $i++;
            $toInsert[$i]['id'] = '13'; 
            $toInsert[$i]['name'] = 'Mendoza'; 

            $i++;
            $toInsert[$i]['id'] = '14'; 
            $toInsert[$i]['name'] = 'Misiones'; 

            $i++;
            $toInsert[$i]['id'] = '15'; 
            $toInsert[$i]['name'] = 'Neuquén'; 

            $i++;
            $toInsert[$i]['id'] = '16'; 
            $toInsert[$i]['name'] = 'Río Negro'; 

            $i++;
            $toInsert[$i]['id'] = '17'; 
            $toInsert[$i]['name'] = 'Salta'; 

            $i++;
            $toInsert[$i]['id'] = '18'; 
            $toInsert[$i]['name'] = 'San Juan'; 

            $i++;
            $toInsert[$i]['id'] = '19'; 
            $toInsert[$i]['name'] = 'San Luis'; 

            $i++;
            $toInsert[$i]['id'] = '20'; 
            $toInsert[$i]['name'] = 'Santa Cruz'; 

            $i++;
            $toInsert[$i]['id'] = '21'; 
            $toInsert[$i]['name'] = 'Santa Fé'; 

            $i++;
            $toInsert[$i]['id'] = '22'; 
            $toInsert[$i]['name'] = 'Santiago del Estero'; 

            $i++;
            $toInsert[$i]['id'] = '23'; 
            $toInsert[$i]['name'] = 'Tierra del Fuego'; 

            $i++;
            $toInsert[$i]['id'] = '24'; 
            $toInsert[$i]['name'] = 'Tucumán'; 

            foreach($toInsert as $insertRow){ 
                $this->insert('province', $insertRow);

            }


            unset($toInsert);
        
        }Catch(Exception $e){
            Yii::app()->db->createCommand($sql)->execute();
            echo 'Sorry got some error';
            return false;
        }
        Yii::app()->db->createCommand($sql)->execute();


    }

    public function down()
    {
        
    }

    /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}