<?php

class m151007_182104_alter_questionary extends CDbMigration
{
	public function up() {
            $this->addColumn('questionary', 'answer', "varchar(255) NULL");
	}

	public function down()
	{
		echo "m151007_182104_alter_questionary does not support migration down.\n";
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