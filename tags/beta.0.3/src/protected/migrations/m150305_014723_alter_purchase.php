<?php

class m150305_014723_alter_purchase extends CDbMigration
{
    public function up()
    {
        $this->alterColumn("purchase", "cae", "VARCHAR(20) NULL");
    }

    public function down()
    {
        echo "m150305_014723_alter_purchase does not support migration down.\n";
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