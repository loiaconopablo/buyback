<?php

class m150817_160457_data_purchase_update_carrier_id extends CDbMigration
{
	public function up()
	{
		$this->update('purchase', array('carrier_id' => Carrier::model()->findByAttributes(array('name' => 'Liberado'))->id), 'carrier_id = 0');
	}

	public function down()
	{
		echo "m150817_160457_data_purchase_update_carrier_id does not support migration down.\n";
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