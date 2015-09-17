<?php

class m150907_180733_update_pricelist extends CDbMigration
{
	public function up()
	{
		$this->update('price_list', array('company_id' => Company::model()->findByAttributes(array('is_owner' => true))->id), 'company_id = 0');
	}

	public function down()
	{
		echo "m150907_180733_update_pricelist does not support migration down.\n";
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