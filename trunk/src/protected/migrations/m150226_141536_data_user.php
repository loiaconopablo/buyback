<?php

class m150226_141536_data_user extends CDbMigration
{
	public function up()
	{
    	
$i=0;
$sql = 'SET foreign_key_checks = 0';
Yii::app()->db->createCommand($sql)->execute();
$sql = 'SET foreign_key_checks = 1';
Try{

/* Dumpling Structure for user*/

$i++;
$toInsert[$i]['id'] = '1'; 
$toInsert[$i]['point_of_sale_id'] = '1'; 
$toInsert[$i]['company_id'] = '1'; 
$toInsert[$i]['username'] = 'root'; 
$toInsert[$i]['password'] = '$2a$13$sSddkJV6zPR5c9oYVFgPie.QJMWj7GhOmjHFNHQLreZDjzdw5tqae'; 
$toInsert[$i]['mail'] = 'rggrinberg@gmail.com'; 
$toInsert[$i]['employee_identification'] = '007'; 
$toInsert[$i]['created_at'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['updated_at'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['last_login'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['user_update_id'] = '0'; 
$toInsert[$i]['is_password_validated'] = '0'; 

$i++;
$toInsert[$i]['id'] = '2'; 
$toInsert[$i]['point_of_sale_id'] = '1'; 
$toInsert[$i]['company_id'] = '1'; 
$toInsert[$i]['username'] = 'bgh'; 
$toInsert[$i]['password'] = '$2a$13$9xGBN87IyKQRw2nT50zd..hkeWzTEuG1RzX3Z9/yQfwGlqyBCjKNC'; 
$toInsert[$i]['mail'] = 'info@bgh.com.ar'; 
$toInsert[$i]['employee_identification'] = '000'; 
$toInsert[$i]['created_at'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['updated_at'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['last_login'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['user_update_id'] = '0'; 
$toInsert[$i]['is_password_validated'] = '0'; 


foreach($toInsert as $insertRow){ 
$this->insert('user', $insertRow);

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