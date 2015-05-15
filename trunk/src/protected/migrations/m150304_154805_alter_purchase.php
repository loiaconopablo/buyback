<?php

class m150304_154805_alter_purchase extends CDbMigration
{
    public function up()
    {
        $this->alterColumn('purchase', 'last_destination_id', 'int(10) unsigned NOT NULL DEFAULT 0');

        $this->alterColumn('purchase', 'last_source_id', 'int(10) unsigned NOT NULL DEFAULT 0');

        $this->alterColumn('purchase', 'last_location_id', 'int(10) unsigned NOT NULL DEFAULT 0');
    }

    public function down()
    {
        echo "m150304_154805_alter_purchase does not support migration down.\n";
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