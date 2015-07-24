<?php

class m150723_210038_create_counters extends CDbMigration
{
	public function up()
	{
		$this->createTable(
            "counters", array(
	            "id"=>"varchar(20) NOT NULL",
	            "description"=>"text",
	            "quantity"=>"BIGINT NOT NULL DEFAULT 0",
	            "PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"
        );
	}

	public function down()
	{
		echo "m150723_210038_create_counters does not support migration down.\n";
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