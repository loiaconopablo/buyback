<?php

class m150625_211531_alter_gif_dictionary_quantity_default extends CDbMigration
{
    public function up()
    {
        $this->alterColumn('gif_dictionary', 'quantity', 'BIGINT NOT NULL DEFAULT 1');
    }

    public function down()
    {
        echo "m150625_211531_alter_gif_dictionary_quantity_default does not support migration down.\n";
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
