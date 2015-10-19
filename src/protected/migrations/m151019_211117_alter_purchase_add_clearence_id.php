<?php

class m151019_211117_alter_purchase_add_clearence_id extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'clearence_id', 'int(10) unsigned NULL');
	}

	public function down()
	{
		echo "m151019_211117_alter_purchase_add_clearence_id does not support migration down.\n";
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