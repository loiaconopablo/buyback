<?php

class m150226_141251_create_authassignment extends CDbMigration
{
	public function up()
	{
    	$this->createTable("authassignment", array(
    "itemname"=>"varchar(64) NOT NULL",
    "userid"=>"varchar(64) NOT NULL",
    "bizrule"=>"text",
    "data"=>"text",
"PRIMARY KEY (itemname,userid)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_bin");


	}

	public function down()
	{
    	$this->dropTable("authassignment");

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