<?php

class m150711_204232_alter_purchase_add_pricelist_log extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'pricelist_log', 'TEXT NULL');
	}

	public function down()
	{
		echo "m150711_204232_alter_purchase_add_pricelist_log does not support migration down.\n";
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