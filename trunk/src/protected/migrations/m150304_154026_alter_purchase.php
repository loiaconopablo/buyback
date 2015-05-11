<?php

class m150304_154026_alter_purchase extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'cae', 'int(15) unsigned NOT NULL DEFAULT 0');
	}

	public function down()
	{
		echo "m150304_154026_alter_purchase does not support migration down.\n";
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