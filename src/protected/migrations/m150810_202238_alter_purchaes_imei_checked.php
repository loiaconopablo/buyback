<?php

class m150810_202238_alter_purchaes_imei_checked extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'imei_checked', 'int(15) NULL');
	}

	public function down()
	{
		echo "m150810_202238_alter_purchaes_imei_checked does not support migration down.\n";
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