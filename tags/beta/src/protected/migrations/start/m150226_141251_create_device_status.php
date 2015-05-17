<?php

class m150226_141251_create_device_status extends CDbMigration
{
    public function up()
    {
        $this->createTable(
            "device_status", array(
            "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
            "slug"=>"varchar(20) NOT NULL",
            "name"=>"varchar(40) NOT NULL",
            "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "user_update_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
            "PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"
        );


    }

    public function down()
    {
        $this->dropTable("device_status");

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