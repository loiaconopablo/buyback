<?php

class m150226_141253_create_contractFks extends CDbMigration
{
	public function up()
	{
    	$this->addForeignKey("contract_device_status", "contract", "device_status_id", "device_status", "id");
$this->addForeignKey("contract_user_log", "contract", "user_update_id", "user", "id");

	}

	public function down()
	{
    	
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