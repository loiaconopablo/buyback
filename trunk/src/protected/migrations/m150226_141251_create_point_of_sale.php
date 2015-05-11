<?php

class m150226_141251_create_point_of_sale extends CDbMigration
{
	public function up()
	{
    	$this->createTable("point_of_sale", array(
    "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
    "company_id"=>"int(10) unsigned NOT NULL",
    "is_headquarter"=>"tinyint(1) NOT NULL",
    "headquarter_id"=>"int(10) unsigned",
    "name"=>"varchar(255) NOT NULL",
    "address"=>"varchar(255) NOT NULL",
    "province"=>"varchar(255) NOT NULL",
    "locality"=>"varchar(255)",
    "phone"=>"varchar(255)",
    "mail"=>"varchar(255)",
    "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "user_update_id"=>"int(10) unsigned",
    "reference_name"=>"varchar(255)",
    "reference_phone"=>"varchar(255)",
    "reference_mail"=>"varchar(255)",
    "is_owner"=>"tinyint(1) NOT NULL",
"PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");


	}

	public function down()
	{
    	$this->dropTable("point_of_sale");

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