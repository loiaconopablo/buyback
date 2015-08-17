<?php

class m150811_040931_alter_purchaes_peoplesoft_blacklist extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'blacklist', 'tinyint(1) NOT NULL DEFAULT 0');
	}

	public function down()
	{
		echo "m150811_040931_alter_purchaes_peoplesoft_blacklist does not support migration down.\n";
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