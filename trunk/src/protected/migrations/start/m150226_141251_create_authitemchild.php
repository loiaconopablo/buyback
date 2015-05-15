<?php

class m150226_141251_create_authitemchild extends CDbMigration
{
    public function up()
    {
        $this->createTable(
            "authitemchild", array(
            "parent"=>"varchar(64) NOT NULL",
            "child"=>"varchar(64) NOT NULL",
            "PRIMARY KEY (parent,child)"), " DEFAULT CHARACTER SET utf8 COLLATE utf8_bin"
        );


    }

    public function down()
    {
        $this->dropTable("authitemchild");

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