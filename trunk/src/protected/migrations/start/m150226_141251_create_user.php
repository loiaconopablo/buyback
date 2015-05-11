<?php

class m150226_141251_create_user extends CDbMigration
{
	public function up()
	{
    	$this->createTable("user", array(
    "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
    "point_of_sale_id"=>"int(10) unsigned",
    "company_id"=>"int(10) unsigned",
    "username"=>"varchar(255) NOT NULL",
    "password"=>"char(64) NOT NULL",
    "mail"=>"varchar(255)",
    "employee_identification"=>"varchar(20)",
    "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "last_login"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "user_update_id"=>"int(10) unsigned",
    "is_password_validated"=>"tinyint(1) unsigned",
"PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");


	}

	public function down()
	{
    	$this->dropTable("user");

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