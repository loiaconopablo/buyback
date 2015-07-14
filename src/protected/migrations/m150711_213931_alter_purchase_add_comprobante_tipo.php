<?php

class m150711_213931_alter_purchase_add_comprobante_tipo extends CDbMigration
{
	public function up()
	{
		$this->addColumn('purchase', 'comprobante_tipo', 'VARCHAR(2) DEFAULT "C"');
	}

	public function down()
	{
		echo "m150711_213931_alter_purchase_add_comprobante_tipo does not support migration down.\n";
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