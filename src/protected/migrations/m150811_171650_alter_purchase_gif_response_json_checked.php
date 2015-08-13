<?php

class m150811_171650_alter_purchase_gif_response_json_checked extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'gif_response_json_checked', 'TEXT');
	}

	public function down()
	{
		echo "m150811_171650_alter_purchase_gif_response_json_checked does not support migration down.\n";
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