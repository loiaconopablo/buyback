<?php

class m150824_210107_alter_purchase_carrier_id extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('purchase', 'carrier_id', "int(10) unsigned NOT NULL");
	}

	public function down()
	{
		echo "m150824_210107_alter_purchase_carrier_id does not support migration down.\n";
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