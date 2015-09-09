<?php

class m150907_160145_alter_pricelist_company_id extends CDbMigration
{
	public function up()
	{
		$this->addColumn('price_list', 'company_id', "int(10) unsigned NOT NULL");
	}

	public function down()
	{
		echo "m150907_160145_alter_pricelist_company_id does not support migration down.\n";
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