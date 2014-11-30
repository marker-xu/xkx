<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'searchcloud' => array(
		'type'       => 'pdo',
		'connection' => array(
			/**
			 * The following options are available for PDO:
			 *
			 * string   dsn         Data Source Name
			 * string   username    database username
			 * string   password    database password
			 * boolean  persistent  use persistent connections?
			 */
			'dsn'        => 'mysql:host=localhost;dbname=search_cloud',
			'username'   => 'search_cloud',
			'password'   => '111111',
			'persistent' => FALSE,
		),
		/**
		 * The following extra options are available for PDO:
		 *
		 * string   identifier  set the escaping identifier
		 */
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
	// MongoDB集群
	'web_mongo' => array(
		'type'       => 'mongo',
		'connection' => array(
    	    'dsn'        => array(
    	    	'mongodb://127.0.0.1:27017', 
            ),
			'timeout'    => 1000,
	    ),
	),
);