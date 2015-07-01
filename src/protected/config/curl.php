<?php
    return array(
            'class' => 'ext.Curl',
            //'options' => array(/* additional curl options */),
            'options'=>array(
                 CURLOPT_TIMEOUT => 60,
                 CURLOPT_RETURNTRANSFER => true,
            ),
        );
