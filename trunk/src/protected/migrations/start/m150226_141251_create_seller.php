<?php

class m150226_141251_create_seller extends CDbMigration
{
	public function up()
	{
    	$this->createTable("seller", array(
    "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
    "name"=>"varchar(255) NOT NULL",
    "dni"=>"int(8) NOT NULL",
    "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "user_update_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
    "address"=>"varchar(255) NOT NULL",
    "province"=>"varchar(255) NOT NULL",
    "locality"=>"varchar(255) NOT NULL",
    "phone"=>"varchar(255)",
"PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");


	}

	public function down()
	{
    	$this->dropTable("seller");

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