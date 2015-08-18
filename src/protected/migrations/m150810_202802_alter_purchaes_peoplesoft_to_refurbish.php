<?php

class m150810_202802_alter_purchaes_peoplesoft_to_refurbish extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'to_refurbish', 'tinyint(1) NOT NULL DEFAULT 1');
	}

	public function down()
	{
		echo "m150810_202802_alter_purchaes_peoplesoft_to_refurbish does not support migration down.\n";
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