<?php

class m151027_184648_alter_clearence_dispatchnote_id extends CDbMigration
{
	public function up()
	{
		$this->addColumn('clearence', 'dispatchnote_id', 'int(10) unsigned NOT NULL DEFAULT 0');
	}

	public function down()
	{
		echo "m151027_184648_alter_clearence_dispatchnote_id does not support migration down.\n";
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