<?php

class m150813_193615_alter_purchase_questionary_checked extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'questionary_json_checked', 'TEXT');
	}

	public function down()
	{
		echo "m150813_193615_alter_purchase_questionary_checked does not support migration down.\n";
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