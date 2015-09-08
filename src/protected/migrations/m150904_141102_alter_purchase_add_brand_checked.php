<?php

class m150904_141102_alter_purchase_add_brand_checked extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'brand_checked', "varchar(255) NOT NULL");
	}

	public function down()
	{
		echo "m150904_141102_alter_purchase_add_brand_checked does not support migration down.\n";
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