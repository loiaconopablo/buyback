<?php

class m150820_191528_data_authitem_wholesale extends CDbMigration
{
	public function up()
	{

        $i=0;
        $sql = 'SET foreign_key_checks = 0';
        Yii::app()->db->createCommand($sql)->execute();
        $sql = 'SET foreign_key_checks = 1';
        Try{

            /* Dumpling Structure for authitem*/

            $i++;
            $toInsert[$i]['name'] = 'wholesale'; 
            $toInsert[$i]['type'] = '2'; 
            $toInsert[$i]['description'] = 'Rol del usuario de compra mayorista'; 
            $toInsert[$i]['bizrule'] = ''; 
            $toInsert[$i]['data'] = 's:0:"";'; 

            

            foreach($toInsert as $insertRow){ 
                $this->insert('authitem', $insertRow);

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
		echo "m150820_191528_data_authitem_wholesale does not support migration down.\n";
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