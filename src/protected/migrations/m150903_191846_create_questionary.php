<?php

class m150903_191846_create_questionary extends CDbMigration
{
	public function up()
    {
        $this->createTable(
            "questionary", array(
            "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
            "question"=>"text",
            "order" => "int(10)",
            "PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"
        );


    }

	public function down()
	{
		echo "m150903_191846_create_questionary does not support migration down.\n";
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