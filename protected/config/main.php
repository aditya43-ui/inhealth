<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
require_once dirname(__FILE__) . '/../components/Params.php';
return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Healtcare',
	'language' => 'id',
	'timeZone' => 'Asia/Jakarta', //Read: http://php.net/manual/en/timezones.php
	// preloading 'log' component
	'preload' => array(
		'log',
		'bootstrap',
	),

	// autoloading model and component classes
	'import' => array(
		'application.models.*',
		'application.controllers.MyAuthController',
		'application.components.*',
		'application.extensions.*',
		'application.extensions.MyBarcode.*',
		'application.extensions.MyOdontogram.*',
		'application.modules.*',
		'application.extensions.GalleryManager.*',
		'application.extensions.GalleryManager.models.*',
		'application.extensions.qrcode.*',

	),

	'modules' => array(
		// uncomment the following to enable the Gii tool

		'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password' => '1234',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters' => array('127.0.0.1', '::1'),
			'generatorPaths' => array(
				'bootstrap.gii', // since 0.9.1
			),
		),
		'chat',

		'ekios', //EK
		'hemodialisa', //HD
		'antrian', //AN
		'pendaftaranPenjadwalan', //PP
		'rekamMedis', //RK
		'rawatJalan', //RJ
		'rawatDarurat', //RD
		'rawatInap', //RI
		'laboratorium', //LB
		'radiologi', //RO
		'billingKasir', //BK
		'farmasiApotek', //FA
		'gudangFarmasi', //GF
		'bedahSentral', //BS
		'gizi', //GZ
		'ambulans', //AM
		'pemulasaranJenazah', //PJ
		'persalinan', //PS
		'rehabMedis', //RM
		'informasi', //IN
		'kepegawaian', //KP
		'remunerasi', //RE
		'gudangUmum', //GU
		'akuntansi', //AK
		'sistemAdministrator', //SA
		'sistemInformasiEksekutif',
		'mcu', //MC
		'keuangan', //KU
		'prescribingControl', //PC
		'mobile', //MO
		'sistemInformasiGeografis', //SG
		'smsCenter', //SM
		'manajemenAset', //MA
		'anggaran', //AG
		'asuhanKeperawatan', //AS
		'laundry', //LA
		'sterilisasi', //ST
		'asuransi', //AR
		'bankDarah', //BD
		'perawatanIntensif', //PI
		'penggajian', //GJ
		'anestesi', //AT
		'pengadaan', //AD
		'mikrobiologiKlinik', // MK
		'mobile', //JM
		'rsOnlineCovid19', // RS ONLINE
		'pelayananKhusus', // PK
		'yankesMasyarakat', // YKM
		'laboratoriumPA', //PA
		'tindakan', //TN

		/*
		 * ----------------------------------------------------------------
		 * DINONAKTIFKAN 2026-08-30 - modul terdaftar tetapi tidak ada
		 * di protected/modules/. Setiap route ke modul-modul ini
		 * menghasilkan error.
		 *
		 * Diverifikasi sebelum dihapus: tidak ada satu pun referensi route
		 * (createUrl / redirect / '<modul>/...') yang menunjuk ke sini.
		 *
		 * Untuk mengaktifkan kembali: pulihkan direktori modulnya lebih
		 * dulu, baru hapus tanda komentar pada barisnya.
		 *
		 *   'dokumenElektronik',  //DE
		 *   'interfacingLab',     //IL
		 *   'pacs',               //PA
		 *   'gasMedis',           //GM
		 *   'litbang',            //LI
		 *   'kecantikan',         //KC
		 *   'pemeliharaanSarana', //SR
		 *   'koperasi',           //KO
		 *   'rumahTangga',        //RT
		 *   'jasamedis',          //JM
		 *   'standardPelayanan',  //SPM
		 * ----------------------------------------------------------------
		 */

		//               SEMENTARA DIHAPUS >> RND-1253 'mobileSIE',
		//				'retail',
		//                SRBAC SUDAH DIGANTIKAN DENGAN MyAuthController
		//                'srbac' => array(
		//                            'userclass' => 'LoginpemakaiK', //default: User
		//                            'userid' => 'loginpemakai_id', //default: userid
		//                            'username' => 'nama_pemakai', //default:username
		//                            'delimeter' => '@', //default:-
		//                            'debug' => false, //default :false
		//                            'pageSize' => 10, // default : 15
		//                            'superUser' => 'Administrator', //default: Authorizer
		//                            'css' => 'srbac.css', //default: srbac.css
		//                            'layout' =>
		//                            'application.views.layouts.main', //default: application.views.layouts.main,
		//                            //must be an existing alias
		//                            'notAuthorizedView' => 'application.modules.srbac.views.authitem.unauthorized', // default:
		//                            //srbac.views.authitem.unauthorized, must be an existing alias
		//                            'alwaysAllowed' => array(),
		//                            'userActions' => array('Show', 'View', 'List'), //default: array()
		//                            'listBoxNumberOfLines' => 15, //default : 10
		//                            'imagesPath' => 'srbac.images', // default: srbac.images
		//                            'imagesPack' => 'noia', //default: noia
		//                            'iconText' => true, // default : false
		//                            'header' => 'application.modules.srbac.views.authitem.header', //default : srbac.views.authitem.header,
		//                            //must be an existing alias
		//                            'footer' => 'application.modules.srbac.views.authitem.footer', //default: srbac.views.authitem.footer,
		//                             //must be an existing alias
		//                            'showHeader' => true, // default: false
		//                            'showFooter' => true, // default: false
		//                            'alwaysAllowedPath' => 'application.modules.srbac.components', // default: srbac.components
		//                            // must be an existing alias
		//                ),

	),

	// application components
	'components' => array(
		'request' => array(
			// Ini memungkinkan Yii untuk secara otomatis mendeteksi host, port, dan protokol
			'baseUrl' => '',
		),
		'yexcel' => array(
			'class' => 'ext.yexcel.Yexcel'
		),

		'messages' => array(
			'basePath' => null
		),
		'coreMessages' => array(
			'basePath' => null
		),
		'user' => array(
			// enable cookie-based authentication
			'allowAutoLogin' => true,
			'returnUrl' => array('/site/index'),

		),
		//                 SRBAC SUDAH DIGANTIKAN DENGAN MyAuthController
		//                 'authManager'=>array(
		//                        'class'=>'application.modules.srbac.components.SDbAuthManager',
		//                        // The database component used
		//                        'connectionID'=>'db',
		//                        // The itemTable name (default:authitem)
		//                        'itemTable'=>'items_k',
		//                        // The assignmentTable name (default:authassignment)
		//                        'assignmentTable'=>'assignments_k',
		//                        // The itemChildTable name (default:authitemchild)
		//                        'itemChildTable'=>'itemchildren_k',
		//                        // uncomment the following to enable URLs in path-format
		//                 ),
		'metadata' => array('class' => 'Metadata'),
		'widgetFactory' => array(
			'widgets' => array(
				/*'MyDateTimePicker'=> array(
                                            'themeUrl' => '/simrs/css/jqueryui',
                                            'theme' => 'cupertino',
                                            'cssFile' => 'jquery-ui-1.8.18.custom.css',
                                        ),
                         'CJuiDialog' => array(
                                            'themeUrl' => '/simrs/css/jqueryui',
                                            'theme' => 'cupertino',
                                            'cssFile' => 'jquery-ui-1.8.18.custom.css',
                                        ),
                         'CJuiAutoComplete' => array(
                                            'themeUrl' => '/simrs/css/jqueryui',
                                            'theme' => 'cupertino',
                                            'cssFile' => 'jquery-ui-1.8.18.custom.css',
                                            'htmlOptions'=>array(
                                                'class'=>'inputAutoComplete',
                                            ),
                                        ),*/),
		),
		// uncomment the following to enable URLs in path-format

		/*'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<module:\w+>/<controller:\w+>/<id:\d+>'=>'<module>/<controller>/view',
				'<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
				'<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
			),
			
		),
                */

		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		'db' => require(dirname(__FILE__) . '/db.php'),
		'db_ris' => require(dirname(__FILE__) . '/db_ris.php'),
		'db_remoteserver' => require(dirname(__FILE__) . '/db_remoteserver.php'),

		'errorHandler' => array(
			// use 'site/error' action to display errors
			//                    'errorAction'=>'site/error',
			'errorAction' => 'reportBugs/index', //RND-5597
		),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
					'enabled' => YII_DEBUG,
				),
				/* AKTIFKAN PHP PROFILER JIKA DIPERLUKAN
                array(
                    'class' => 'application.extensions.pqp.PQPLogRoute',
                    'categories' => 'application.*, exception.*',
                    'enabled'=>YII_DEBUG,
                ),*/
			),
			// 'routes'=>array(
			/*
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
					'enabled'=>YII_DEBUG,
				),
				 */
			// uncomment the following to show log messages on web pages
			/*
				array(
					'class'=>'CWebLogRoute',
				),
				 */
			// 	array(
			// 		'class'=>'application.components.MyReportBugsLog',
			// 		'enabled'=>YII_DEBUG,
			// 	),

			// ),
		),
		'bootstrap' => array(
			'class' => 'ext.bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
			'coreCss' => true, // whether to register the Bootstrap core CSS (bootstrap.min.css), defaults to true
			'responsiveCss' => false, // whether to register the Bootstrap responsive CSS (bootstrap-responsive.min.css), default to false
			'coreCssTheme' => true,
			'coreCssFontIcon' => true,
			'plugins' => array(
				// Optionally you can configure the "global" plugins (button, popover, tooltip and transition)
				// To prevent a plugin from being loaded set it to false as demonstrated below
				'transition' => false, // disable CSS transitions
				'tooltip' => array(
					//'selector'=>'a.tooltip', // bind the plugin tooltip to anchor tags with the 'tooltip' class
					'selector' => Params::TOOLTIP_SELECTOR, // bind the plugin tooltip to anchor tags with the 'tooltip' class
					'options' => array(
						'placement' => Params::TOOLTIP_PLACEMENT, // place the tooltips below instead
					),
				),
				// If you need help with configuring the plugins, please refer to Bootstrap's own documentation:
				// http://twitter.github.com/bootstrap/javascript.html
			),
		),


	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => array(
		// this is used in contact page
		'adminEmail' => 'webmaster@example.com',
		'seckey' => sha1('ehealthsys240117'),
		'tambahan' => require(dirname(__FILE__) . '/tambahan.php'),
	),
);