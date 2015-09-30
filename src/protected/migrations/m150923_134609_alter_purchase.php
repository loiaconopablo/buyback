<?php

class m150923_134609_alter_purchase extends CDbMigration {

    public function up() {
        $this->addColumn('purchase', 'selling_code', "varchar(50) NULL");
    }

    public function down() {
        echo "m150923_134609_alter_purchase does not support migration down.\n";
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
