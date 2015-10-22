<?php

class m151007_182345_data_questionary extends CDbMigration {

    public function up() {
        $this->truncateTable('questionary');

        $i = 0;
        $sql = 'SET foreign_key_checks = 0';
        Yii::app()->db->createCommand($sql)->execute();
        $sql = 'SET foreign_key_checks = 1';
        Try {

            /* Dumpling Structure for carrier */

            $i++;
            $toInsert[$i]['question'] = '¿El equipo tiene su batería?';
            $toInsert[$i]['order'] = '1';
            $toInsert[$i]['answer'] = 'No tiene su bateria';

            $i++;
            $toInsert[$i]['question'] = '¿El equipo tiene su tapa trasera?';
            $toInsert[$i]['order'] = '2';
            $toInsert[$i]['answer'] = 'No tiene la tapa trasera';

            $i++;
            $toInsert[$i]['question'] = ' ¿El equipo enciende?';
            $toInsert[$i]['order'] = '3';
            $toInsert[$i]['answer'] = 'No enciende';

            $i++;
            $toInsert[$i]['question'] = '¿El equipo toma señal?';
            $toInsert[$i]['order'] = '4';
            $toInsert[$i]['answer'] = 'No toma señal';

            $i++;
            $toInsert[$i]['question'] = '¿Tiene el visor sano y funciona el táctil?';
            $toInsert[$i]['order'] = '5';
            $toInsert[$i]['answer'] = 'Visor roto o táctil no funciona';
            
            $i++;
            $toInsert[$i]['question'] = '¿Tiene el display sano y enciende?';
            $toInsert[$i]['order'] = '6';
            $toInsert[$i]['answer'] = 'Display roto o no enciende';
            
            $i++;
            $toInsert[$i]['question'] = '¿El equipo pasa la verificación visual de humedad? (sensores, conectores, etiqueta afip desteñida, etc)';
            $toInsert[$i]['order'] = '7';
            $toInsert[$i]['answer'] = 'Rastros visibles de humedad';

            foreach ($toInsert as $insertRow) {
                $this->insert('questionary', $insertRow);
            }


            unset($toInsert);
        } Catch (Exception $e) {
            Yii::app()->db->createCommand($sql)->execute();
            echo 'Sorry got some error';
            return false;
        }
        Yii::app()->db->createCommand($sql)->execute();
    }

    public function down() {
        echo "m151007_182345_data_questionary does not support migration down.\n";
        return false;
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
