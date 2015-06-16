<?php

class m150612_181645_alter_purchase extends CDbMigration
{
    public function up()
    {
        $this->addColumn('price_list', 'name', 'VARCHAR(200) NULL');
    }

    public function down()
    {
        echo "m150612_181645_alter_purchase does not support migration down.\n";
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
