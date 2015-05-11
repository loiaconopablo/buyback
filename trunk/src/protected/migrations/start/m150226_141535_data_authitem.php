<?php

class m150226_141535_data_authitem extends CDbMigration
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
$toInsert[$i]['name'] = 'admin'; 
$toInsert[$i]['type'] = '2'; 
$toInsert[$i]['description'] = 'Administrador de BGH
Administra Empresas, Usuarios, Puntos de venta y Lista de precios'; 
$toInsert[$i]['bizrule'] = ''; 
$toInsert[$i]['data'] = 's:0:"";'; 

$i++;
$toInsert[$i]['name'] = 'personal'; 
$toInsert[$i]['type'] = '2'; 
$toInsert[$i]['description'] = 'es un retail especial solo para los locales de Personal'; 
$toInsert[$i]['bizrule'] = ''; 
$toInsert[$i]['data'] = 's:0:"";'; 

$i++;
$toInsert[$i]['name'] = 'retail'; 
$toInsert[$i]['type'] = '2'; 
$toInsert[$i]['description'] = 'Usuario para los Puntos de Venta'; 
$toInsert[$i]['bizrule'] = ''; 
$toInsert[$i]['data'] = 's:0:"";'; 

$i++;
$toInsert[$i]['name'] = 'superuser'; 
$toInsert[$i]['type'] = '2'; 
$toInsert[$i]['description'] = 'Usuario de desarrollo
Tiene permiso a todo'; 
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