<?php

class m150828_200441_alter_purchase_purchase_price extends CDbMigration
{
	public function up()
	{
	}

	public function down()
	{
		$this->alterColumn('purchase', 'purchase_price', 'DECIMAL(8,2) NOT NULL');
     
        $this->alterColumn('purchase', 'paid_price', 'DECIMAL(8,2) NOT NULL');
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