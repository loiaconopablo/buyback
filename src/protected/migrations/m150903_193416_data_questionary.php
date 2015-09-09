<?php

class m150903_193416_data_questionary extends CDbMigration
{
	public function up()
    {
        
        $i=0;
        $sql = 'SET foreign_key_checks = 0';
        Yii::app()->db->createCommand($sql)->execute();
        $sql = 'SET foreign_key_checks = 1';
        Try{

            /* Dumpling Structure for carrier*/

            $i++;
            $toInsert[$i]['question'] = 'El equipo tiene su batería y su tapa trasera'; 
            $toInsert[$i]['order'] = '1'; 

            $i++;
            $toInsert[$i]['question'] = 'El equipo enciende y puede realizar una llamada'; 
            $toInsert[$i]['order'] = '2';

            $i++;
            $toInsert[$i]['question'] = 'El equipo tiene su visor o display en buen estado (no estallado ni rajado)'; 
            $toInsert[$i]['order'] = '3';

            $i++;
            $toInsert[$i]['question'] = 'El equipo no tiene rastros de haber sido mojado'; 
            $toInsert[$i]['order'] = '4';

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
		echo "m150903_193416_data_questionary does not support migration down.\n";
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