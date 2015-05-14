<?php

class m150514_012125_alter_purchase_contract_number extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('purchase', 'contract_number', 'VARCHAR(20) NOT NULL');
	}

	public function down()
	{
		echo "m150514_012125_alter_purchase_contract_number does not support migration down.\n";
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