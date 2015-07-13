<?php

class m150711_205907_alter_purchase_add_user_ip extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'user_ip', 'VARCHAR(20) NULL');
	}

	public function down()
	{
		echo "m150711_205907_alter_purchase_add_user_ip does not support migration down.\n";
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