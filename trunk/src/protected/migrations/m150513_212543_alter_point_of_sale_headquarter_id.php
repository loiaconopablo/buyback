<?php

class m150513_212543_alter_point_of_sale_headquarter_id extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('point_of_sale', 'headquarter_id', 'int(10) unsigned NULL');
	}

	public function down()
	{
		echo "m150513_212543_alter_point_of_sale_headquarter_id does not support migration down.\n";
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