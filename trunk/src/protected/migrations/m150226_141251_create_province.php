<?php

class m150226_141251_create_province extends CDbMigration
{
	public function up()
	{
    	$this->createTable("province", array(
    "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
    "name"=>"varchar(50) NOT NULL",
"PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");


	}

	public function down()
	{
    	$this->dropTable("province");

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