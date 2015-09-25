<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Time',

	// preloading 'log' component
	'preload'=>array('log','bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),
        'language' => 'it',
	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
                'bootstrap' => array(
                    'class' => 'aliased.path.to.yiibooster.directory.and.inside.it.Bootstrap.class'
                ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
                        'showScriptName' => false,
                        'caseSensitive' => false,
			'rules'=>array(
                                'site/page/<view:\w+>' => 'site/page',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

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
                'ldap' => require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ldap.php'),
                'cache' => array(
                    'class' => 'CFileCache',
                ),
                'bootstrap' => array(
                    'class' => 'application.extensions.yiibooster.components.Bootstrap',
                ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'carlos.manzo@nad.it',
                'supportEmail' => 'carlos.manzo@nad.it',
                'company' => 'NAD',
                'dateDisplayFormat' => 'dd-MM-yyyy HH:mm:ss',
                'dateSaveFormat' => 'yyyy-MM-dd HH:mm:ss',
                'stdDateDisplayFormat' => 'd-m-Y H:i:s',
                'stdDateSaveFormat' => 'Y-m-d H:i:s',
                'debug' => true,
                'loginRememberEnabled' => false,
                'identityClass' => 'LdapUserIdentity',
                'ldap' => array(
                    'host' => '192.168.215.10',
                    'port'=>389,
                    'domain'=>'nad',
                    'ou' => 'Users',
                    'dc' => array('nad','local'),
                    'username'=>'Admin',
                    'password'=>'R0m4gn4!!',
                    'tls_on'=>false,
                ),
	),
);
