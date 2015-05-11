<?php
	return array(
            'class' => 'ext.Curl',
            //'options' => array(/* additional curl options */),
            'options'=>array(
	             CURLOPT_TIMEOUT => 60,
	             CURLOPT_RETURNTRANSFER => true,
	             CURLOPT_HTTPHEADER => array('Accept: application/json', 'Content-type: application/json'),
	        ),
        );