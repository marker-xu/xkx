<?php defined('SYSPATH') or die('No direct script access.');

return array
(
	'search' => array(
		'type' => RPC_TYPE_THRIFT,
		'option' => array(
			'balance' => 'Rpc_Balance_RoundRobin',
			'transport' => 'TFramedTransport',		
			'protocol' => NULL,	
			'ctimeout' => 1000,
			'wtimeout' => 2000,
			'rtimeout' => 7000,
		),
		'server' => array(
			array('host' => 'searchroot.sii.sdo.com', 'port' => 9090),
		),		
	),
        //上铺接口
	'shop_api' => array(
		'type' => RPC_TYPE_HTTP,
		'option' => array(
			'balance' => 'Rpc_Balance_RoundRobin',
			'ctimeout' => 1000,
			'wtimeout' => 2000,
			'rtimeout' => 3000,
		),
		'server' => array(
			array('host' => '127.0.0.1', 'port' => 8080),
		),		
	),
        //提示接口
        'sug_api' => array(
                'type' => RPC_TYPE_HTTP,
                'option' => array(
                        'balance' => 'Rpc_Balance_RoundRobin',
                        'ctimeout' => 1000,
                        'wtimeout' => 2000,
                        'rtimeout' => 3000,
                ),
                'server' => array(
                        array('host' => '127.0.0.1', 'port' => 8080),
                ),
        ),
        //用户相关接口
        'user_api' => array(
                'type' => RPC_TYPE_HTTP,
                'option' => array(
                        'balance' => 'Rpc_Balance_RoundRobin',
                        'ctimeout' => 1000,
                        'wtimeout' => 2000,
                        'rtimeout' => 3000,
                ),
                'server' => array(
                        array('host' => '127.0.0.1', 'port' => 8080),
                ),
        ),
        //菜品接口
        'dish_api' => array(
                'type' => RPC_TYPE_HTTP,
                'option' => array(
                        'balance' => 'Rpc_Balance_RoundRobin',
                        'ctimeout' => 1000,
                        'wtimeout' => 2000,
                        'rtimeout' => 3000,
                ),
                'server' => array(
                        array('host' => '127.0.0.1', 'port' => 8080),
                ),
        ),
        //订单接口
        'order_api' => array(
                'type' => RPC_TYPE_HTTP,
                'option' => array(
                        'balance' => 'Rpc_Balance_RoundRobin',
                        'ctimeout' => 1000,
                        'wtimeout' => 2000,
                        'rtimeout' => 3000,
                ),
                'server' => array(
                        array('host' => '127.0.0.1', 'port' => 8080),
                ),
        ),
);