<?php

class m150818_192949_insert_authitem_company_admin extends CDbMigration
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
            $toInsert[$i]['name'] = 'company_admin'; 
            $toInsert[$i]['type'] = '2'; 
            $toInsert[$i]['description'] = 'Rol que permite ver reportes y estadísticas por empresa'; 
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
		echo "m150818_192949_insert_authitem_company_admin does not support migration down.\n";
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