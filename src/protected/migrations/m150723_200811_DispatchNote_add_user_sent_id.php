<?php

class m150723_200811_DispatchNote_add_user_sent_id extends CDbMigration
{
	public function up()
	{
        $this->addColumn('dispatch_note', 'user_sent_id', 'INT(10) unsigned');
	}

	public function down()
	{
		echo "m150723_200811_DispatchNote_add_user_sent_id does not support migration down.\n";
		return true;
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
