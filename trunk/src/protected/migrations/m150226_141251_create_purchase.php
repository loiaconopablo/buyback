<?php

class m150226_141251_create_purchase extends CDbMigration
{
    public function up()
    {
        $this->createTable(
            "purchase", array(
            "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
            "company_id"=>"int(10) unsigned NOT NULL",
            "point_of_sale_id"=>"int(10) unsigned NOT NULL",
            "headquarter_id"=>"int(10) unsigned NOT NULL",
            "user_create_id"=>"int(10) unsigned NOT NULL",
            "seller_id"=>"int(10) unsigned NOT NULL",
            "contract_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
            "last_dispatch_note_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
            "carrier_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
            "price_list_id"=>"int(10) unsigned NOT NULL",
            "imei"=>"int(15) NOT NULL",
            "brand"=>"varchar(255) NOT NULL",
            "model"=>"varchar(255) NOT NULL",
            "carrier_name"=>"varchar(255) NOT NULL",
            "price_type"=>"varchar(20) NOT NULL",
            "purchase_price"=>"int(11) NOT NULL",
            "paid_price"=>"int(11) NOT NULL",
            "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "user_update_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
            "contract_number"=>"bigint(20) NOT NULL",
            "current_status_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
            "last_location_id"=>"tinyint(1) NOT NULL",
            "last_source_id"=>"tinyint(1) NOT NULL",
            "last_destination_id"=>"tinyint(1) NOT NULL",
            "PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"
        );


    }

    public function down()
    {
        $this->dropTable("purchase");

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