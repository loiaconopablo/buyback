<?php

class m150817_155151_data_carriern_liberado extends CDbMigration
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
            $toInsert[$i]['id'] = '4'; 
            $toInsert[$i]['name'] = 'Liberado'; 
            $toInsert[$i]['description'] = 'Equipo desbloqueado'; 

            foreach($toInsert as $insertRow){ 
                $this->insert('carrier', $insertRow);

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
		echo "m150817_155151_data_carriern_liberado does not support migration down.\n";
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