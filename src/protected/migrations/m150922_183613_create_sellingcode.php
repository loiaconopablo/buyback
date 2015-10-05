<?php

class m150922_183613_create_sellingcode extends CDbMigration {

    public function up() {
        $this->createTable(
                "sellingcode", array(
            "id" => "int(10) unsigned NOT NULL AUTO_INCREMENT",
            "brand" => "varchar(255) NOT NULL",
            "model" => "varchar(255) NOT NULL",
            "movistar_a" => "varchar(50) NULL",
            "personal_a" => "varchar(50) NULL",
            "claro_a" => "varchar(50) NULL",
            "libre_a" => "varchar(50) NULL",
            "movistar_b" => "varchar(50) NULL",
            "personal_b" => "varchar(50) NULL",
            "claro_b" => "varchar(50) NULL",
            "libre_b" => "varchar(50) NULL",
            "bad_refurbish" => "varchar(50) NULL",
            "bad_irreparable" => "varchar(50) NULL",
            "PRIMARY KEY (id)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci"
        );
    }

    public function down() {
        echo "m150922_183613_create_sellingcode does not support migration down.\n";
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
