<?php

class m150806_164816_data_authitem_newrol_technical_supervisor extends CDbMigration
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
            $toInsert[$i]['name'] = 'technical_supervisor'; 
            $toInsert[$i]['type'] = '2'; 
            $toInsert[$i]['description'] = 'Retail del supervisor técnico tiene que pertenecer a un retail de BGH que sea cabecera'; 
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
		echo "m150806_164816_data_authitem_newrol_technical_supervisor does not support migration down.\n";
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