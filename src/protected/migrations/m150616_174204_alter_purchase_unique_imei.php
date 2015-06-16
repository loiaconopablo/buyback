<?php

class m150616_174204_alter_purchase_unique_imei extends CDbMigration
{
    public function up()
    {
        $this->createIndex('imei', 'purchase', 'imei', true);
    }

    public function down()
    {
        echo "m150616_174204_alter_purchase_unique_imei does not support migration down.\n";
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
