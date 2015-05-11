<?php

class m150325_195528_alter_point_of_sale extends CDbMigration {
	public function up() {
		$this->alterColumn('point_of_sale', 'headquarter_id', 'int(10) unsigned NOT NULL');
	}

	public function down() {
		echo "m150325_195528_alter_point_of_sale does not support migration down.\n";
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