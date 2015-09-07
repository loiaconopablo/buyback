<?php

class m150907_175331_create_index_price_list extends CDbMigration
{
	public function up()
	{
		$this->createIndex('company_id_brand_model', 'price_list', array('company_id', 'brand', 'model'));
	}

	public function down()
	{
		echo "m150907_175331_create_index_price_list does not support migration down.\n";
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