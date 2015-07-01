<?php

class m150625_183109_create_gif_dictionary extends CDbMigration
{
    public function up()
    {
        $this->createTable(
            "gif_dictionary",
            array(
            "id"=>"int(10) unsigned NOT NULL AUTO_INCREMENT",
            "name"=>"varchar(200) NOT NULL",
            "brand"=>"varchar(200) NOT NULL",
            "model"=>"varchar(200) NOT NULL",
            "quantity"=>"BIGINT unsigned",
            "created_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "updated_at"=>"timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            "user_update_id"=>"int(10) unsigned",
            "PRIMARY KEY (id)"),
            " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"
        );

        $this->createIndex('name', 'gif_dictionary', 'name');

        $this->createIndex('name_brand_model', 'gif_dictionary', array('name', 'brand', 'model'), true);
    }

    public function down()
    {
        echo "m150625_183109_create_gif_dictionary does not support migration down.\n";
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
