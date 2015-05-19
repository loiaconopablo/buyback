<?php

class m150302_195821_create_contract_number extends CDbMigration
{
    public function up()
    {
        $this->createTable(
            "contract_number", array(
            "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
            "last_contract_number" => "BIGINT NOT NULL DEFAULT 0",
            "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "user_update_id"=>"int(10) unsigned",
            "PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"
        );

    }

    public function down()
    {
        echo "m150302_195821_create_contract_number does not support migration down.\n";
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