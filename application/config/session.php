<?php defined('SYSPATH') or die('No direct script access.');

// ini_set('session.gc_maxlifetime', 86400);
// ini_set('session.save_handler', 'redis');
// ini_set('session.save_path', 'tcp://127.0.0.1:6379?weight=1&timeout=1');

return array(
	'native' => array(
        'name' => 'PHPSESSID',
        'lifetime' => 86400 * 30,
    ),
);