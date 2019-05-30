<?php 
use \Ideahut\sdms\Common;
use \Ideahut\sdms\cache\Cache;

use \App\Project;

$_COMMON_NS_    = "\\Ideahut\\sdms";
$_PROJECT_NS_   = "\\App";
$_RESPONSE_     = $_COMMON_NS_ . "\\response\\MediaTypeResponse";

return [
    Common::SETTING_SETTINGS => [
        
        // monolog settings
        Common::SETTING_LOGGER => [
            'name' => 'app',
			'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ . '/logs/sdms-sample.log',
        ],
		
		// Doctrine Settings
        'doctrine' => [
            'meta' => [
                'entity_path' => [
                    __DIR__ . '/src/entity',
					
					// ADD OTHER DOMAIN PATH HERE !!!
					
                ],
                'auto_generate_proxies' => false, // true untuk development
                'proxy_dir' =>  __DIR__ . '/cache/proxies',
                'cache' => new \Doctrine\Common\Cache\ApcuCache(),
            ],
			
			// MYSQL            
			'connection' => [
                'driver'   => 'pdo_mysql',
				'port'     => '3306',
                'dbname'   => 'sdms_sample',
                'host' 	   => '127.0.0.1',
                'user' 	   => 'root',
                'password' => 'root'
            ]
			
			// SQL SERVER
            /*
			'connection' => [
                'driver'   => 'pdo_sqlsrv',
                'host'     => 'localhost',
				'port'     => '1433',
                'dbname'   => 'sdms_sample',
                'user'     => 'sa',
                'password' => 'sa12345',
            ]
            */			
			
			// ORACLE
			/*
			'connection' => [
                'driver'   => 'oci8',
                'host'     => 'localhost',
				'port'     => '1521',
                'dbname'   => 'xe',
                'user'     => 'php_slim_doctrine',
                'password' => 'php_slim_doctrine',
            ]
			*/
			
			// POSTGRE SQL
            /*
			'connection' => [
                'driver'   => 'pdo_pgsql',
                'host'     => 'localhost',
				'port'     => '5432',
                'dbname'   => 'sdms_sample',
                'user'     => 'postgres',
                'password' => 'postgres',
            ]
			*/
        ],
		
		// Cache Settings
		// Cara kerjanya akan dicek ke memory terlebih dahulu, jika tidak tersedia maka akan diambil ke data source (bisa DB, File, dll) 
		// selanjutnya object akan disimpan ke memory. 
		// - limit      : maksimum jumlah object yang disimpan di memory
		// - expiration : maksimum umur (diisi 0 = UNLIMITED) object di memory (tapi tidak akan dibuang dari memory sampai ada request), dalam satuan milidetik
		// - nullable   : object null akan disimpan di memory (untuk menghindari pemanggilan yg selalu ke data source jika object memang tidak tersedia)
        Common::SETTING_CACHE => [
            
            Cache::PROVIDER => $_COMMON_NS_ . "\\cache\\provider\\ApcuCache",
            Cache::PARAMETER => [
                Cache::UNLIMITED => false,
            ],
            /*            
            Cache::PROVIDER => $_COMMON_NS_ . "\\cache\\provider\\RedisCache",
            Cache::PARAMETER => [
                'host' => '127.0.0.1',
                'port' => 6380,
                'password' => 'rahasia',
                Cache::UNLIMITED => false,
            ],
            */
            Cache::GROUP => [
				Project::CACHE_ACCESS => [
					Cache::LIMIT => 500,
					Cache::EXPIRATION => 0,
					Cache::NULLABLE => 1
				],
			]			
		],

        
        /**
         * CONSTANT
         */
        Common::SETTING_APP_DIR => __DIR__,
        Common::SETTING_PUBLIC_DIR => __DIR__ . "/../public",
        Common::SETTING_NAMESPACE_DIR => ["\\App\\" => "src\\", "App\\" => "src\\"], 
        Common::SETTING_CORS_ORIGIN => "*",
        Common::SETTING_CORS_METHODS => "GET, POST, PUT, DELETE, OPTIONS",
        Common::SETTING_CORS_HEADERS => "X-Requested-With, Content-Type, Accept, Origin, Authorization, Access-Key",


        /**
         * ROUTE
         */
        Common::SETTING_ROUTE => [
            [
                Common::SETTING_PATH => "/api/[{path:.*}]",
                Common::SETTING_CONTROLLER => $_PROJECT_NS_ . "\\controller\\",
                Common::SETTING_VALIDATOR => $_PROJECT_NS_ . "\\validator\\",
                Common::SETTING_RESPONSE => $_RESPONSE_,
                Common::SETTING_SUFFIX => [
                    Common::SETTING_CONTROLLER => "Controller"
                ],
                Common::SETTING_ACCESS => [
                    Common::SETTING_CLASS => $_PROJECT_NS_ . "\\access\\KeyAccess",
                    Common::SETTING_PARAMETER =>[
                        "EXPIRATION_IN_SECOND"=> 86400,
                    ],
                ],
            ],
            [
                Common::SETTING_PATH => "/manage/[{path:.*}]",
                Common::SETTING_CONTROLLER => $_PROJECT_NS_ . "\\manage\\",
                Common::SETTING_RESPONSE => $_RESPONSE_,
            ]
        ],

        /**
         * ADMIN
         */
        Common::SETTING_ADMIN => [
            Common::SETTING_ENTITY => [$_PROJECT_NS_ . "\\entity\\"],
            Common::SETTING_RESPONSE => $_RESPONSE_,
            Common::SETTING_DEBUG => true,
            Common::SETTING_ACCESS => [
                Common::SETTING_CLASS => $_PROJECT_NS_ . "\\access\\AdminAccess",
                //Common::SETTING_PARAMETER =>["a"=>1, "b"=>2],
            ],
        ],

        /**
         * HESSIAN
         */
        Common::SETTING_HESSIAN => [
            Common::SETTING_ACCESS => [
                Common::SETTING_CLASS => $_PROJECT_NS_ . "\\access\\KeyAccess",
                Common::SETTING_PARAMETER => [
                    "EXPIRATION_IN_SECOND"=> 86400,
                ],
            ],
            Common::SETTING_PATH => [
                "/test" => [
                    Common::SETTING_SERVICE => $_PROJECT_NS_ . "\\service\\TestService",
                    Common::SETTING_IS_PUBLIC => true,
                ],
            ],
        ],

        /**
         * DOCUMENT
         */
        Common::SETTING_DOCUMENT => [
            Common::SETTING_ENTITY => [$_PROJECT_NS_ . "\\entity\\",  $_COMMON_NS_ . "\\object\\"],
            Common::SETTING_CONTROLLER => [$_PROJECT_NS_ . "\\controller\\"],
        ],

        /**
         * SEQUENCE
         */
        //Common::SETTING_SEQUENCE => [
        //    "TEST" => [Common::SETTING_START => 0, Common::SETTING_MAX => 999],
        //],

    ],
];