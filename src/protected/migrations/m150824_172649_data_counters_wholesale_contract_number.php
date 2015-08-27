<?php

class m150824_172649_data_counters_wholesale_contract_number extends CDbMigration
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
            $toInsert[$i]['id'] = 'wholesale_number'; 
            $toInsert[$i]['description'] = 'Numero de contrato de las compras mayoristas';
            $toInsert[$i]['quantity'] = 0;


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
		echo "m150824_172649_data_counters_wholesale_contract_number does not support migration down.\n";
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