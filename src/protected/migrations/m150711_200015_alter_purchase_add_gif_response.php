<?php

class m150711_200015_alter_purchase_add_gif_response extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'gif_response_json', 'TEXT NULL');
	}

	public function down()
	{
		echo "m150711_200015_alter_purchase_add_gif_response does not support migration down.\n";
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