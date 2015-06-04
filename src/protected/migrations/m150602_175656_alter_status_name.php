<?php

class m150602_175656_alter_status_name extends CDbMigration
{
    public function up()
    {
        $this->alterColumn("status", "name", "VARCHAR(255) NULL");
    }

    public function down()
    {
        echo "m150602_175656_alter_status_name does not support migration down.\n";
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
