<?php

class m150423_160445_clear_purchase_data extends CDbMigration {
	public function up() {
		$this->truncateTable('dispatch_note');
		$this->truncateTable('purchase_status');
		$this->truncateTable('purchase');
		$this->truncateTable('seller');
	}

	public function down() {
		echo "m150423_160445_clear_purchase_data does not support migration down.\n";
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