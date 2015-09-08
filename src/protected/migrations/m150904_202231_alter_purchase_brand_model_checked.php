<?php

class m150904_202231_alter_purchase_brand_model_checked extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('purchase', 'brand_checked', "varchar(255) NULL");

		$this->alterColumn('purchase', 'model_checked', "varchar(255) NULL");
	}

	public function down()
	{
		echo "m150904_202231_alter_purchase_brand_model_checked does not support migration down.\n";
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