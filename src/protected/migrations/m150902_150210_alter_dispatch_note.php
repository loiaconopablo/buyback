<?php

class m150902_150210_alter_dispatch_note extends CDbMigration
{
	public function up()
	{
            $this->addColumn('dispatch_note', 'comment_received', 'text');
	}

	public function down()
	{
		echo "m150902_150210_alter_dispatch_note does not support migration down.\n";
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