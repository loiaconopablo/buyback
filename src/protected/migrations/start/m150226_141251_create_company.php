<?php

class m150226_141251_create_company extends CDbMigration
{
    public function up()
    {
        $this->createTable(
            "company", array(
            "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
            "name"=>"varchar(255) NOT NULL",
            "social_reason"=>"varchar(255) NOT NULL",
            "cuit"=>"varchar(11) NOT NULL",
            "address"=>"varchar(255) NOT NULL",
            "province"=>"varchar(255) NOT NULL",
            "locality"=>"varchar(255)",
            "phone"=>"varchar(255)",
            "mail"=>"varchar(255)",
            "percent_fee"=>"decimal(6,2)",
            "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "user_update_id"=>"int(10) unsigned",
            "company_code"=>"varchar(100) NOT NULL",
            "reference_name"=>"varchar(255)",
            "reference_phone"=>"varchar(255)",
            "reference_mail"=>"varchar(255)",
            "last_contract_number"=>"bigint(20) NOT NULL DEFAULT '0'",
            "is_owner"=>"tinyint(1) NOT NULL",
            "last_dispatch_note_number"=>"bigint(20) NOT NULL DEFAULT '0'",
            "PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"
        );


    }

    public function down()
    {
        $this->dropTable("company");

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