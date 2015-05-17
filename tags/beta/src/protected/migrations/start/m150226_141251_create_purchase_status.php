<?php

class m150226_141251_create_purchase_status extends CDbMigration
{
    public function up()
    {
        $this->createTable(
            "purchase_status", array(
            "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
            "purchase_id"=>"int(10) unsigned NOT NULL",
            "status_id"=>"int(10) unsigned NOT NULL",
            "comment"=>"text",
            "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "user_update_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
            "point_of_sale_id"=>"int(10) unsigned NOT NULL",
            "company_id"=>"int(10) unsigned NOT NULL",
            "headquarter_id"=>"int(10) unsigned NOT NULL",
            "dispatch_note_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
            "PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"
        );


    }

    public function down()
    {
        $this->dropTable("purchase_status");

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