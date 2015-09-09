<?php

class m150907_175122_drop_index_pricelist extends CDbMigration
{
	public function up()
	{
		$this->dropIndex('brand_model', 'price_list');
	}

	public function down()
	{
		echo "m150907_175122_drop_index_pricelist does not support migration down.\n";
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