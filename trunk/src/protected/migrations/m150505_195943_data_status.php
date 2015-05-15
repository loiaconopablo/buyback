<?php

class m150505_195943_data_status extends CDbMigration
{
    public function up() 
    {

        $i = 0;
        $sql = 'SET foreign_key_checks = 0';
        Yii::app()->db->createCommand($sql)->execute();
        $sql = 'SET foreign_key_checks = 1';
        Try {

            /* Dumpling Structure for province*/

            $i++;
            $toInsert[$i]['id'] = '10';
            $toInsert[$i]['constant_name'] = 'PENDING';
            $toInsert[$i]['name'] = 'Pendiente';

            $i++;
            $toInsert[$i]['id'] = '20';
            $toInsert[$i]['constant_name'] = 'PENDING_TO_SEND';
            $toInsert[$i]['name'] = 'Pendiente de envío';

            $i++;
            $toInsert[$i]['id'] = '30';
            $toInsert[$i]['constant_name'] = 'SENT';
            $toInsert[$i]['name'] = 'Enviado';

            $i++;
            $toInsert[$i]['id'] = '40';
            $toInsert[$i]['constant_name'] = 'RECEIVED';
            $toInsert[$i]['name'] = 'Recibido';

            $i++;
            $toInsert[$i]['id'] = '50';
            $toInsert[$i]['constant_name'] = 'PENDING_TO_BE_RECEIVED';
            $toInsert[$i]['name'] = 'Pendiente de ser recibido';

            $i++;
            $toInsert[$i]['id'] = '60';
            $toInsert[$i]['constant_name'] = 'CANCELLED';
            $toInsert[$i]['name'] = 'Cancelado';

            $i++;
            $toInsert[$i]['id'] = '70';
            $toInsert[$i]['constant_name'] = 'IN_OBSERVATION';
            $toInsert[$i]['name'] = 'En observación';

            $i++;
            $toInsert[$i]['id'] = '80';
            $toInsert[$i]['constant_name'] = 'APPROVED';
            $toInsert[$i]['name'] = 'Aprobado';

            $i++;
            $toInsert[$i]['id'] = '90';
            $toInsert[$i]['constant_name'] = 'REJECTED';
            $toInsert[$i]['name'] = 'Rechazado';

            $i++;
            $toInsert[$i]['id'] = '100';
            $toInsert[$i]['constant_name'] = 'REQUOTED';
            $toInsert[$i]['name'] = 'Recotizado';

            $i++;
            $toInsert[$i]['id'] = '110';
            $toInsert[$i]['constant_name'] = 'PAID';
            $toInsert[$i]['name'] = 'Liquidado';

            foreach ($toInsert as $insertRow) {
                $this->insert('status', $insertRow);

            }

            unset($toInsert);

        } Catch (Exception $e) {
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