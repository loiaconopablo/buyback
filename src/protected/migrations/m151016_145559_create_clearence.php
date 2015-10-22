<?php

class m151016_145559_create_clearence extends CDbMigration
{
	public function up()
	{
		 $this->createTable(
            "clearence", array(
            "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
            "company_id"=>"int(10) unsigned NOT NULL",
            "user_create_id"=>"int(10) unsigned NOT NULL",
            "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "user_update_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
            "total_purchase" => 'DECIMAL(8,2) NOT NULL DEFAULT 0',
            "total_paid" => 'DECIMAL(8,2) NOT NULL DEFAULT 0',
            "error_allowance" => 'DECIMAL(8,2) NOT NULL DEFAULT 0',
            "paid_comision" => 'DECIMAL(8,2) NOT NULL DEFAULT 0',
            "total_comision" => 'DECIMAL(8,2) NOT NULL DEFAULT 0',
            "PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"
        );

	}

	public function down()
	{
		echo "m151016_145559_create_clearence does not support migration down.\n";
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