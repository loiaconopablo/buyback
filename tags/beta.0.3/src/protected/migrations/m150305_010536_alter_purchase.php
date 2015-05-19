<?php

class m150305_010536_alter_purchase extends CDbMigration
{
    public function up()
    {
        $this->renameColumn('purchase', 'cae_request', 'cae_response_json');
    }

    public function down()
    {
        echo "m150305_010536_alter_purchase does not support migration down.\n";
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