<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'theme'=>'bootstrap',//ankit // requires you to copy the theme under your themes directory
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'tw.in',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.mail.mandrill.*',//mind the case sensitive path in linux
		'application.components.sms.india.springedge.*',//mind the case sensitive path in linux
        //'application.modules.user.models.*',
        //'application.modules.user.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'root',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
            'generatorPaths'=>array(
                'bootstrap.gii',
		),
		/*'gii'=>array(
            'generatorPaths'=>array(
                'bootstrap.gii',
            ),*/
        ),//ankit
        'user'=>array(
            # encrypting method (php hash function)
            'hash' => 'no_encryption',//'sha1',no_encryption
 
            # send activation email
            'sendActivationMail' => false,
 
            # allow access for non-activated users
            'loginNotActiv' => false,
 
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => true,
 
            # automatically login from registration
            'autoLogin' => true,
 
            # registration path
            'registrationUrl' => array('/user/registration'),
 
            # recovery password path
            'recoveryUrl' => array('/user/recovery/recovery'),
 
            # login form path
            'loginUrl' => array('/user/login'),
 
            # page after login
            'returnUrl' => array('/site/index'),
			
			'profileUrl' => array('/site/index'),
 
            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),
	),

	// application components
	'components'=>array(
	'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),//ankit
		
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'caseSensitive'=>false,
			'rules'=>array(
				'gii'=>'gii',
            	'gii/<controller:\w+>'=>'gii/<controller>',
            	'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
            	'user/<controller:\w+>/<action:\w+>/*'=>'user/<controller>/<action>',
				'<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',
			),
		),
		
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=tinku',
			'emulatePrepare' => true,
			'username' => 'web',
			'password' => 'ankitbisht',
			'charset' => 'utf8',
		),
		
		'db_session'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=tinku_session',
			'emulatePrepare' => true,
			'username' => 'web_session',
			'password' => 'ankitbisht',
			'charset' => 'utf8',
		),
		
		'session'=>array(
				'class'=>'CDbHttpSession',
				'connectionID'=>'db_session',
				'sessionTableName'=>'session_table',
				'timeout' => 86400,
			),
		
		'clientScript'=>array(
				'class'=>'AppClientScript',
			),
		
		'securityManager'=>array(
				'validationKey'=>'_validationKey_validationKey_validationKey_validationKey',
				'encryptionKey'=>'_encryptionKey_encryptionKey_enc',//Encryption key length can be 16,24,32.
			),
    
    	'request' => array(
				'class'=>'AppHttpRequest',
        		'enableCsrfValidation' => true,
        		'enableCookieValidation' => true,//adds HMAC code to cookies created by server
				'noCsrfValidationRoutes'=>array('x/y',/*'user/login',*/),
        		'csrfTokenName' =>'csrf_token',//r.h.s. csrf_token is used in js files too. if changing here
        		//do change at js files too.
    		),
		
		'user'=>array(
				'class'=>'AppWebUser',
				'loginUrl'=>array('/user/login'),
				'allowAutoLogin'=>true,
				//'loginRequiredAjaxResponse'=>'Your session has expired. Please log in again using login page.',
			),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
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
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'ankit.bisht.kec@gmail.com',
		'timezone'=>'Asia/Calcutta',
		'cartCookieName'=>'twcart',
		'googleAnalyticsApiKey'=>'UA-xxxxxxxx-1',//put your key
		'mandrillApiKey'=>'xxx',//put your key
		'springedgeApiKey'=>'xxx',//put your key
		'springedgeUrl'=>"http://alerts.springedge.com/api",
		'springedgeSecuredUrl'=>"https://alerts.springedge.com/api",
		'springedgeSenderId'=>"TTWWIN",//put your sms alias
	),
);