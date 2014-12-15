<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'xkx' => array(
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
			'dsn'        => 'mysql:host=127.0.0.1;dbname=test',
			'username'   => 'test',
			'password'   => '123456',
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