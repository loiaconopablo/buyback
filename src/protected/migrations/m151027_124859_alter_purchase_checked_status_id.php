<?php

class m151027_124859_alter_purchase_checked_status_id extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'checked_status_id', 'int(10) unsigned NOT NULL DEFAULT 0');
	}

	public function down()
	{
		echo "m151027_124859_alter_purchase_checked_status_id does not support migration down.\n";
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