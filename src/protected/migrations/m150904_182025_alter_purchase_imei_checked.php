<?php

class m150904_182025_alter_purchase_imei_checked extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('purchase', 'imei_checked', 'VARCHAR(16) NOT NULL');
	}

	public function down()
	{
		echo "m150904_182025_alter_purchase_imei_checked does not support migration down.\n";
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