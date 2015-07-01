<?php

class m150623_210402_alter_price_list_add_imeiws_name extends CDbMigration
{
    public function up()
    {
        $this->addColumn('price_list', 'imeiws_name', 'VARCHAR(250) NULL');
    }

    public function down()
    {
        echo "m150623_210402_alter_price_list_add_imeiws_name does not support migration down.\n";
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
