<?php

class m150625_173357_alter_price_list_delete_imeiws_name extends CDbMigration
{
    public function up()
    {
        $this->dropColumn('price_list', 'imeiws_name');
    }

    public function down()
    {
        echo "m150625_173357_alter_price_list_delete_imeiws_name does not support migration down.\n";
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
