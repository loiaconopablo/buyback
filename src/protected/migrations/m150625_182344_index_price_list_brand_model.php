<?php

class m150625_182344_index_price_list_brand_model extends CDbMigration
{
    public function up()
    {
        $this->createIndex('brand_model', 'price_list', array('brand', 'model'), true);
    }

    public function down()
    {
        echo "m150625_182344_index_price_list_brand_model does not support migration down.\n";
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
