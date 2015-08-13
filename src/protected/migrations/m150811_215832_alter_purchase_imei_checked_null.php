<?php

class m150811_215832_alter_purchase_imei_checked_null extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('purchase', 'imei_checked', 'int(15) NULL');
	}

	public function down()
	{
		echo "m150811_215832_alter_purchase_imei_checked_null does not support migration down.\n";
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