<?php

class m150804_205937_create_forecast extends CDbMigration
{
	public function up()
	{
		$this->createTable(
            "forecast", array(
            "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
            "month"=>"int(10) NOT NULL",
            "year"=>"int(10) NOT NULL",
            "quantity"=>"BIGINT NOT NULL",
            "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "user_update_id"=>"int(10) unsigned",
            "PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"
        );
	}

	public function down()
	{
		echo "m150804_205937_create_forecast does not support migration down.\n";
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