<?php

class m150730_140455_data_authitemchild extends CDbMigration
{
	public function up()
    {
        
        $i=0;
        $sql = 'SET foreign_key_checks = 0';
        Yii::app()->db->createCommand($sql)->execute();
        $sql = 'SET foreign_key_checks = 1';
        Try{

            /* Dumpling Structure for authitemchild*/

            $i++;
            $toInsert[$i]['parent'] = 'requoter'; 
            $toInsert[$i]['child'] = 'retail'; 

            foreach($toInsert as $insertRow){ 
                $this->insert('authitemchild', $insertRow);

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
		echo "m150730_140455_data_authitemchild does not support migration down.\n";
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