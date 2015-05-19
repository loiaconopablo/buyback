<?php

class m150304_231422_alter_purchase extends CDbMigration
{
    public function up()
    {
        $this->addColumn('purchase', 'importe_neto', 'DECIMAL(8,2) NOT NULL DEFAULT 0');
        $this->addColumn('purchase', 'importe_iva', 'DECIMAL(8,2) NOT NULL DEFAULT 0');
        $this->addColumn('purchase', 'cae_request', 'TEXT NULL');
    }

    public function down()
    {
        echo "m150304_231422_alter_purchase does not support migration down.\n";
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