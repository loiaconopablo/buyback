<?php

class m150226_141251_create_authitem extends CDbMigration
{
	public function up()
	{
    	$this->createTable("authitem", array(
    "name"=>"varchar(64) NOT NULL",
    "type"=>"int(11) NOT NULL",
    "description"=>"text",
    "bizrule"=>"text",
    "data"=>"text",
"PRIMARY KEY (name)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_bin");


	}

	public function down()
	{
    	$this->dropTable("authitem");

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