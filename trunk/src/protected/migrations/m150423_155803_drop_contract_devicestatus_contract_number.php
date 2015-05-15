<?php

class m150423_155803_drop_contract_devicestatus_contract_number extends CDbMigration
{
    public function up() 
    {
        $this->dropTable('contract');
        $this->dropTable('device_status');
        $this->dropTable('contract_number');
    }

    public function down() 
    {
        echo "m150423_155803_drop_contract_devicestatus_contract_number does not support migration down.\n";
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