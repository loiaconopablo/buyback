<?php

class m150226_141251_create_contract extends CDbMigration
{
	public function up()
	{
    	$this->createTable("contract", array(
    "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
    "seller_name"=>"varchar(255) NOT NULL",
    "seller_dni"=>"int(8) NOT NULL",
    "point_of_sale_address"=>"varchar(255) NOT NULL",
    "employee_identification"=>"varchar(20)",
    "device_imei"=>"int(15) NOT NULL",
    "device_brand"=>"varchar(255) NOT NULL",
    "device_model"=>"varchar(255) NOT NULL",
    "device_price"=>"int(11) NOT NULL",
    "device_status_id"=>"int(10) unsigned NOT NULL",
    "afip_cai"=>"int(12) NOT NULL",
    "afip_cae"=>"int(12) NOT NULL",
    "pdf_uri"=>"varchar(255) NOT NULL",
    "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
    "user_update_id"=>"int(10) unsigned NOT NULL DEFAULT '0'",
"PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");


	}

	public function down()
	{
    	$this->dropTable("contract");

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