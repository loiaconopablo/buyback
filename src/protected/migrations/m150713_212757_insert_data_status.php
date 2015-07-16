<?php

class m150713_212757_insert_data_status extends CDbMigration
{
	public function up()
	{
		$i = 0;
        $sql = 'SET foreign_key_checks = 0';
        Yii::app()->db->createCommand($sql)->execute();
        $sql = 'SET foreign_key_checks = 1';
        Try {

            /* Dumpling Structure for province*/

            $i++;
            $toInsert[$i]['id'] = '61';
            $toInsert[$i]['constant_name'] = 'CANCELLATION';
            $toInsert[$i]['name'] = 'Anulación';

            foreach ($toInsert as $insertRow) {
                $this->insert('status', $insertRow);

            }

            unset($toInsert);

        } Catch (Exception $e) {
            Yii::app()->db->createCommand($sql)->execute();
            echo 'Sorry got some error';
            return false;
        }
        Yii::app()->db->createCommand($sql)->execute();
	}

	public function down()
	{
		echo "m150713_212757_insert_data_status does not support migration down.\n";
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