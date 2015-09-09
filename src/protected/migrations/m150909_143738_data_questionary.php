<?php

class m150909_143738_data_questionary extends CDbMigration
{
	public function up()
	{
		$this->truncateTable('questionary');

		$i=0;
        $sql = 'SET foreign_key_checks = 0';
        Yii::app()->db->createCommand($sql)->execute();
        $sql = 'SET foreign_key_checks = 1';
        Try{

            /* Dumpling Structure for carrier*/

            $i++;
            $toInsert[$i]['question'] = '¿El equipo tiene su batería y su tapa trasera? (dichos accesorios pueden estar rotos o no ser originales)'; 
            $toInsert[$i]['order'] = '1'; 

            $i++;
            $toInsert[$i]['question'] = 'El equipo enciende y puede realizar una llamada'; 
            $toInsert[$i]['order'] = '2';

            $i++;
            $toInsert[$i]['question'] = ' ¿El equipo tiene su visor sano? (no debe estar rajado)'; 
            $toInsert[$i]['order'] = '3';

            $i++;
            $toInsert[$i]['question'] = '¿El equipo tiene su display sano? (no debe estar estallado y tiene que encender)'; 
            $toInsert[$i]['order'] = '4';

            $i++;
            $toInsert[$i]['question'] = '  ¿El equipo pasa la verificación visual de humedad? (sensores, conectores, desteñido de etiqueta afip)'; 
            $toInsert[$i]['order'] = '5';

            foreach($toInsert as $insertRow){ 
                $this->insert('questionary', $insertRow);

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
		echo "m150909_143738_data_questionary does not support migration down.\n";
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