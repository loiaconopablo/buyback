<?php

class m150226_141253_create_purchaseFks extends CDbMigration
{
    public function up()
    {
        $this->addForeignKey("purchase_point_of_sale", "purchase", "point_of_sale_id", "point_of_sale", "id");

    }

    public function down()
    {
        
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