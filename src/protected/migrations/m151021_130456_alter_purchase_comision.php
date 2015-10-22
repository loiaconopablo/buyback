<?php

class m151021_130456_alter_purchase_comision extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'comision', 'DECIMAL(8,2) NOT NULL DEFAULT 0');
		$this->addColumn('purchase', 'company_percent_fee', 'DECIMAL(8,2) NOT NULL DEFAULT 0');
	}

	public function down()
	{
		echo "m151021_130456_alter_purchase_comision does not support migration down.\n";
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