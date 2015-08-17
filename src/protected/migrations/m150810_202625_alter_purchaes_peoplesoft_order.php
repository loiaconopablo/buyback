<?php

class m150810_202625_alter_purchaes_peoplesoft_order extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'peoplesoft_order', 'VARCHAR(50) NULL');
	}

	public function down()
	{
		echo "m150810_202625_alter_purchaes_peoplesoft_order does not support migration down.\n";
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