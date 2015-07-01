<?php

class m150624_145250_alter_price_list_delete_name extends CDbMigration
{
    public function up()
    {
        $this->dropColumn('price_list', 'name');
    }

    public function down()
    {
        echo "m150624_145250_alter_price_list_delete_name does not support migration down.\n";
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
