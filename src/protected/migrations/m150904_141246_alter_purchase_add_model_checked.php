<?php

class m150904_141246_alter_purchase_add_model_checked extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'model_checked', "varchar(255) NOT NULL");
	}

	public function down()
	{
		echo "m150904_141246_alter_purchase_add_model_checked does not support migration down.\n";
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