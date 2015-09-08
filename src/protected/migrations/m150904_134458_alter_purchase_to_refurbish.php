<?php

class m150904_134458_alter_purchase_to_refurbish extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('purchase', 'to_refurbish', 'tinyint(1) NULL');
	}

	public function down()
	{
		echo "m150904_134458_alter_purchase_to_refurbish does not support migration down.\n";
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