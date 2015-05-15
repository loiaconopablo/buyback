<?php

class m150226_141536_data_company extends CDbMigration
{
    public function up()
    {
        
        $i=0;
        $sql = 'SET foreign_key_checks = 0';
        Yii::app()->db->createCommand($sql)->execute();
        $sql = 'SET foreign_key_checks = 1';
        Try{

            /* Dumpling Structure for company*/

            $i++;
            $toInsert[$i]['id'] = '1'; 
            $toInsert[$i]['name'] = 'BGH'; 
            $toInsert[$i]['social_reason'] = 'BGH S.A.'; 
            $toInsert[$i]['cuit'] = '21474836472'; 
            $toInsert[$i]['address'] = 'Brasil 731'; 
            $toInsert[$i]['province'] = 'Ciudad Autonoma de Buenos Aires'; 
            $toInsert[$i]['locality'] = 'C.A.B.A.'; 
            $toInsert[$i]['phone'] = '+54 114983-1341'; 
            $toInsert[$i]['mail'] = 'info@bgh.com.ar'; 
            $toInsert[$i]['percent_fee'] = '0.00'; 
            $toInsert[$i]['created_at'] = '0000-00-00 00:00:00'; 
            $toInsert[$i]['updated_at'] = '0000-00-00 00:00:00'; 
            $toInsert[$i]['user_update_id'] = '0'; 
            $toInsert[$i]['company_code'] = '001'; 
            $toInsert[$i]['reference_name'] = ''; 
            $toInsert[$i]['reference_phone'] = ''; 
            $toInsert[$i]['reference_mail'] = ''; 
            $toInsert[$i]['last_contract_number'] = '0'; 
            $toInsert[$i]['is_owner'] = '1'; 
            $toInsert[$i]['last_dispatch_note_number'] = '0'; 

            foreach($toInsert as $insertRow){ 
                $this->insert('company', $insertRow);

            }


            unset($toInsert);
        
        }Catch(Exception $e){
            Yii::app()->db->createCommand($sql)->execute();
            echo 'Sorry got some error';
            return false;
        }
        Yii::app()->db->createCommand($sql)->execute();


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