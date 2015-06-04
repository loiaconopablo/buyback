<?php

class m150602_180208_data_status extends CDbMigration
{
    public function up()
    {
        $this->update('status', array('name' => 'Pendiente de ser recibido'), 'id = 50');
    }

    public function down()
    {
        echo "m150602_180208_data_status does not support migration down.\n";
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
