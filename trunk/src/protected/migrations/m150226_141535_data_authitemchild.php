<?php

class m150226_141535_data_authitemchild extends CDbMigration
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
$toInsert[$i]['parent'] = 'personal'; 
$toInsert[$i]['child'] = 'retail'; 

$i++;
$toInsert[$i]['parent'] = 'superuser'; 
$toInsert[$i]['child'] = 'admin'; 

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