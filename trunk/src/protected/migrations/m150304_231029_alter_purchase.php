<?php

class m150304_231029_alter_purchase extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('purchase', 'purchase_price', 'DECIMAL(8,2) NOT NULL DEFAULT 0');

		$this->alterColumn('purchase', 'paid_price', 'DECIMAL(8,2) NOT NULL DEFAULT 0');
	}

	public function down()
	{
		echo "m150304_231029_alter_purchase does not support migration down.\n";
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