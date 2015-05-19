<?php

class m150513_185928_alter_purchase_imei extends CDbMigration
{
    public function up()
    {
        $this->alterColumn('purchase', 'imei', 'VARCHAR(16) NOT NULL');
    }

    public function down()
    {
        echo "m150513_185928_alter_purchase_imei does not support migration down.\n";
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