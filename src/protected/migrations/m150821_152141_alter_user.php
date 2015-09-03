<?php

class m150821_152141_alter_user extends CDbMigration
{
	public function up()
	{
            $this->addColumn('user', 'password_generated', 'char(64)');
	}

	public function down()
	{
		echo "m150821_152141_alter_user does not support migration down.\n";
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