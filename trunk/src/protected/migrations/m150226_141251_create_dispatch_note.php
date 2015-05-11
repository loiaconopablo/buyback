<?php

class m150226_141251_create_dispatch_note extends CDbMigration
{
	public function up()
	{
    	$this->createTable("dispatch_note", array(
    "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
    "company_id"=>"int(10) unsigned NOT NULL",
    "source_id"=>"int(10) unsigned NOT NULL",
    "comment"=>"text",
    "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "user_update_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
    "status"=>"int(10) unsigned NOT NULL DEFAULT '0'",
    "sent_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "finished_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "destination_id"=>"int(10) unsigned NOT NULL",
    "dispatch_note_number"=>"bigint(20) NOT NULL",
    "user_create_id"=>"int(10) unsigned",
"PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");


	}

	public function down()
	{
    	$this->dropTable("dispatch_note");

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