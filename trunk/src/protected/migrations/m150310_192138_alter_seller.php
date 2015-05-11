<?php

class m150310_192138_alter_seller extends CDbMigration {
	public function up() {
		$this->addColumn('seller', 'mail', "varchar(255) NOT NULL");
	}

	public function down() {
		echo "m150310_192138_alter_seller does not support migration down.\n";
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