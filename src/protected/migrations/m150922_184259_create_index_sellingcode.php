<?php

class m150922_184259_create_index_sellingcode extends CDbMigration
{
	public function up()
	{
            $this->createIndex('sellingcode_id_brand_model', 'sellingcode', array('brand', 'model'));
	}

	public function down()
	{
		echo "m150922_184259_create_index_sellingcode does not support migration down.\n";
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