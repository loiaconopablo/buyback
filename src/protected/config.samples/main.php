<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'buyback',

    // preloading 'log' component
    'preload' => array('log', 'EJSUrlManager'),

    'language' => 'es',

    'defaultController' => 'auth/auth/login',

    // path aliases
    'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../../../vendor/crisu83/yiistrap'), // change this if necessary
        'vendor' => realpath(__DIR__ . '/../../../vendor'),
        'giix' => realpath(__DIR__ . '/../../../vendor/assisrafael/giix'),
    ),

    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'zii.widgets.CWidget.*',

        'bootstrap.helpers.*',
        'bootstrap.behaviors.*',
        'bootstrap.widgets.*',
        'bootstrap.components.*',
        //'vendor.assisrafael.giix.components.*', // giix components
        'giix.components.*', // giix components

        //'application.vendors.PHPExcel',

    ),

    'modules' => array(
        'auth' => array(),
        'users' => array(),
        'rights' => array(),
        'admin_root' => array(),
        'admin' => array(),
        'purchase' => array(),
        'dispatchnote' => array(),
        'report' => array(),
        'clearence' => array(),
        'notification' => array(),
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123456',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1', '192.168.33.1'),
            'generatorPaths' => array('giix.generators', 'bootstrap.gii'),
        ),
    ),

    // application components
    'components' => array(

        'session' => array(
            'cookieMode' => 'only',
        ),

        'format' => array(
            'numberFormat' => array('decimals'=>2, 'decimalSeparator'=>',', 'thousandSeparator'=>''),
        ),

        'queue' => array(
            'class' => 'nfy.components.NfyDbQueue',
            'label' => 'Notificaciones',
            'timeout' => 30,
        ),

        // Descomentar esto en producción
        // Para que funcione el script de entrada (src/index.php) debe tener comentada la linea de debug
        // 'assetManager' => array(
        //     'linkAssets' => true,
        // ),

        'clientScript'=>array(
            'packages'=>array(
                'jquery'=>array(
                    'baseUrl'=> './js/',
                    'js'=>array('jquery.min.js')
                )
            )
        ),


        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
        ),


        'user' => array(
            // enable cookie-based authentication
            'loginUrl' => 'auth/auth/login',
            'allowAutoLogin' => true,
            'class' => 'WebUser',
            'autoUpdateFlash' => false,
        ),

        'EJSUrlManager' => array(
            'class' => 'ext.JSUrlManager.src.EJSUrlManager',
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'caseSensitive' => true,
            'rules' => array(
                //'authitemchild/view/<parent:\w+>/<child:\w+>'=>'<controller>/<action>',
                '/login' => '/auth/auth/login',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

            ),
        ),

        'db' => include dirname(__FILE__) . '/database.php',

        'ePdf' => include dirname(__FILE__) . '/epdf.php',

        'curl' => include dirname(__FILE__) . '/curl.php',
        
        'imeiws' => include dirname(__FILE__) . '/wsgif.php',

        'wsfe' => include dirname(__FILE__) . '/wsfe.php',

        'mailer' => include dirname(__FILE__) . '/mailer.php',

        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => '/default/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, notice',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'logFile'=>'blacklist.log',
                    'categories'=>'blacklist.*',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'logFile'=>'gif_not_match.log',
                    'categories'=>'gif_not_match.*',
                ),
                array(
                    'class'=>'CEmailLogRoute',
                    'levels'=>'error, warning',
                    'emails'=>'rggrinberg@gmail.com',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'rggrinberg@gmail.com',
    ),
);
