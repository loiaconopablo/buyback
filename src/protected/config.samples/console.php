<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'My Console Application',

    // preloading 'log' component
    'preload'=>array('log'),

    // path aliases
    'aliases' => array(
        'giix' => realpath(__DIR__ . '/../../../vendor/assisrafael/giix'),
    ),

    // preloading 'log' component
    'preload'=>array('log'),
    'import' => array(
        'application.models.*',
        'giix.components.*', // giix components
    ),

    // application components
    'components'=>array(

        // database settings are configured in database.php
        'db'=>include dirname(__FILE__).'/database.php',

        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
            ),
        ),

    ),
);
