<?php

class m150226_141535_data_carrier extends CDbMigration
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
$toInsert[$i]['id'] = '1'; 
$toInsert[$i]['name'] = 'Personal'; 
$toInsert[$i]['description'] = ''; 
$toInsert[$i]['created_at'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['updated_at'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['user_update_id'] = '10'; 

$i++;
$toInsert[$i]['id'] = '2'; 
$toInsert[$i]['name'] = 'Claro'; 
$toInsert[$i]['description'] = ''; 
$toInsert[$i]['created_at'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['updated_at'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['user_update_id'] = '0'; 

$i++;
$toInsert[$i]['id'] = '3'; 
$toInsert[$i]['name'] = 'Movistar'; 
$toInsert[$i]['description'] = ''; 
$toInsert[$i]['created_at'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['updated_at'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['user_update_id'] = '10'; 

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