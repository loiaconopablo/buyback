<?php

class m150226_141536_data_point_of_sale extends CDbMigration
{
	public function up()
	{
    	
$i=0;
$sql = 'SET foreign_key_checks = 0';
Yii::app()->db->createCommand($sql)->execute();
$sql = 'SET foreign_key_checks = 1';
Try{

/* Dumpling Structure for point_of_sale*/

$i++;
$toInsert[$i]['id'] = '1'; 
$toInsert[$i]['company_id'] = '1'; 
$toInsert[$i]['is_headquarter'] = '1'; 
$toInsert[$i]['headquarter_id'] = '1'; 
$toInsert[$i]['name'] = 'Cabecera BGH'; 
$toInsert[$i]['address'] = 'Piedras 1470'; 
$toInsert[$i]['province'] = 'Ciudad Autonoma de Buenos Aires'; 
$toInsert[$i]['locality'] = 'C,A.B.A.'; 
$toInsert[$i]['phone'] = '+54 1149831341'; 
$toInsert[$i]['mail'] = 'info@bgh.com.ar'; 
$toInsert[$i]['created_at'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['updated_at'] = '0000-00-00 00:00:00'; 
$toInsert[$i]['user_update_id'] = '0'; 
$toInsert[$i]['reference_name'] = ''; 
$toInsert[$i]['reference_phone'] = ''; 
$toInsert[$i]['reference_mail'] = ''; 
$toInsert[$i]['is_owner'] = '1'; 


foreach($toInsert as $insertRow){ 
$this->insert('point_of_sale', $insertRow);

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