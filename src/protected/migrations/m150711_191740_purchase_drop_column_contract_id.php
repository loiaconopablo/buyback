<?php

class m150711_191740_purchase_drop_column_contract_id extends CDbMigration
{
	public function up()
	{
		$this->dropColumn('purchase', 'contract_id');
	}

	public function down()
	{
		echo "m150711_191740_purchase_drop_column_contract_id does not support migration down.\n";
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