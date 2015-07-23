<?php

class m150723_211018_data_counters extends CDbMigration
{
	public function up()
    {
        
        $i=0;
        $sql = 'SET foreign_key_checks = 0';
        Yii::app()->db->createCommand($sql)->execute();
        $sql = 'SET foreign_key_checks = 1';
        Try{

            /* Dumpling Structure for counters*/

            $i++;
            $toInsert[$i]['id'] = 'contract_number'; 
            $toInsert[$i]['description'] = 'Numero de contrato mientras se usa CAI';
            $toInsert[$i]['quantity'] = 1000;


            foreach($toInsert as $insertRow){ 
                $this->insert('counters', $insertRow);

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
		echo "m150723_211018_data_counters does not support migration down.\n";
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