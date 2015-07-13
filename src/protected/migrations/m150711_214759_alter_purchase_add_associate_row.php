<?php

class m150711_214759_alter_purchase_add_associate_row extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'associate_row', 'BIGINT NULL');
	}

	public function down()
	{
		echo "m150711_214759_alter_purchase_add_associate_row does not support migration down.\n";
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