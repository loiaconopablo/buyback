<?php

class m150226_141251_create_status extends CDbMigration
{
    public function up()
    {
        $this->createTable(
            "status", array(
            "id"=>"int(10) unsigned NOT NULL",
            "constant_name"=>"varchar(255) NOT NULL",
            "name"=>"varchar(20) NOT NULL",
            "description"=>"text",
            "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "user_update_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
            "PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"
        );


    }

    public function down()
    {
        $this->dropTable("status");

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