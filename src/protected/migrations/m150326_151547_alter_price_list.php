<?php

class m150326_151547_alter_price_list extends CDbMigration
{
    public function up() 
    {
        $this->alterColumn('price_list', 'locked_price', 'DECIMAL(8,2) NOT NULL DEFAULT 0');
        $this->alterColumn('price_list', 'unlocked_price', 'DECIMAL(8,2) NOT NULL DEFAULT 0');
        $this->alterColumn('price_list', 'broken_price', 'DECIMAL(8,2) NOT NULL DEFAULT 0');
    }

    public function down() 
    {
        echo "m150326_151547_alter_price_list does not support migration down.\n";
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