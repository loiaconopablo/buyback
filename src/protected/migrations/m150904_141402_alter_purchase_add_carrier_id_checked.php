<?php

class m150904_141402_alter_purchase_add_carrier_id_checked extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'carrier_id_checked', "int(10) unsigned NOT NULL DEFAULT '0'");
	}

	public function down()
	{
		echo "m150904_141402_alter_purchase_add_carrier_id_checked does not support migration down.\n";
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