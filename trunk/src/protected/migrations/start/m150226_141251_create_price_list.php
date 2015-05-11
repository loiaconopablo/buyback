<?php

class m150226_141251_create_price_list extends CDbMigration
{
	public function up()
	{
    	$this->createTable("price_list", array(
    "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
    "brand"=>"varchar(255) NOT NULL",
    "model"=>"varchar(255) NOT NULL",
    "locked_price"=>"int(11) NOT NULL",
    "unlocked_price"=>"int(11) NOT NULL",
    "broken_price"=>"int(11) NOT NULL",
    "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "user_update_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
"PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");


	}

	public function down()
	{
    	$this->dropTable("price_list");

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