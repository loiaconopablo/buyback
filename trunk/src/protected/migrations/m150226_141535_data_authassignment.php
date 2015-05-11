<?php

class m150226_141535_data_authassignment extends CDbMigration
{
	public function up()
	{
    	
$i=0;
$sql = 'SET foreign_key_checks = 0';
Yii::app()->db->createCommand($sql)->execute();
$sql = 'SET foreign_key_checks = 1';
Try{

/* Dumpling Structure for authassignment*/
$i++;
$toInsert[$i]['itemname'] = 'superuser'; 
$toInsert[$i]['userid'] = '1'; 
$toInsert[$i]['bizrule'] = ''; 
$toInsert[$i]['data'] = 'N;'; 

$i++;
$toInsert[$i]['itemname'] = 'admin'; 
$toInsert[$i]['userid'] = '2'; 
$toInsert[$i]['bizrule'] = ''; 
$toInsert[$i]['data'] = 'N;'; 

foreach($toInsert as $insertRow){ 
$this->insert('authassignment', $insertRow);

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