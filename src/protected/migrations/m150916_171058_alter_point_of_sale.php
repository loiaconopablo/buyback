<?php

class m150916_171058_alter_point_of_sale extends CDbMigration
{
	public function up()
	{
            $this->createIndex('point_of_sale_name', 'point_of_sale', 'name', true);
	}

	public function down()
	{
		echo "m150916_171058_alter_point_of_sale does not support migration down.\n";
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