<?php defined('SYSPATH') or die('No direct script access.');
// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

// Load the core JKit class
require MODPATH.'jkit/classes/jkit'.EXT;

if (is_file(APPPATH.'class/jkit'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/jkit'.EXT;	
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Asia/Shanghai');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('zh-cn');

/**
 * 设置cookie加密令牌
 */
Cookie::$salt = 'jkit.admin.example.com';

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	JKit::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}
else{
	JKit::$environment = JKit::DEVELOPMENT;
}

//注册模块
$arrTmpMod = array(
	'jkit'		=>  MODPATH.'jkit',			 // the JKit framework
	// 'auth'       => MODPATH.'auth',       // Basic authentication
	'cache'      => MODPATH.'cache',         // Caching with multiple backends
	'database'   => MODPATH.'database',   // Database access
	'email'   => MODPATH.'email',   //Send email helper
	'unittest'   => MODPATH.'unittest',      // Unit testing
	'image'      => MODPATH.'image',      // Image manipulation
	// 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
    'pagination' => APPPATH.'/modules/pagination',
    'opensdk'    => APPPATH.'/modules/opensdk',
);
if (defined('DEBUG_MODE') && DEBUG_MODE) {
	$arrTmpMod += array(
		'tests'		=>	MODPATH.'jkit/tests',	 // the tests for JKit
		'codebench'  => MODPATH.'codebench',  // Benchmarking tool
		'unittest'   => MODPATH.'unittest',      // Unit testing
		'userguide'  => MODPATH.'userguide',     // User guide and API documentation	
	);
}
JKit::register_modules($arrTmpMod);
unset($arrTmpMod);

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
JKit::init(array(
	'base_url'   => NULL,
	'cache_dir'  => DOCROOT.'/cache/',
	'index_file' => false,
	'charset' => 'utf-8',
//	'caching' => DEBUG_MODE ? false : true,
	'errors' => false,
//	'profile' => DEBUG_MODE ? true : false,
	'caching'    => JKit::$environment == JKit::DEVELOPMENT ? false : true,
	'profile'    => JKit::$environment == JKit::DEVELOPMENT ? true : false,
));
//Attach the file write to logging. Multiple writers are supported.
JKit::$log->attach(new Log_File(DOCROOT.'logs', 'JKit_Log',
		JKit::$environment == JKit::DEVELOPMENT ? Log_File::SPLIT_DAY : Log_File::SPLIT_HOUR
	)
	,JKit::$environment == JKit::DEVELOPMENT ? LOG::DEBUG : LOG::ERROR
    , 0, 'JKit_Core_Log_Writer'
);
require_once APPPATH.'config/main.php';
set_exception_handler(array('ExceptionHandler', 'handle'));
//初始化各个模块
JKit::init_modules();
JKit::$template_settings['compile_dir'] = APPPATH.'../_smarty/tpl_c/';
JKit::$template_settings['config_dir'] = APPPATH.'views/conf/';
JKit::$template_settings['cache_dir'] = APPPATH.'../_smarty/cache/';

//JKit::$security['csrf'] = false;
//JKit::$security['xss']  = false;
JKit::$security['non-ajax access']  = true;
//用户的route配置
Route::set('user', 'user/(<id>(/<action>(/<type>)))', array('id' => '\d+', 'type' => '[\d\w-_]*'))
->defaults(array(
'controller' => 'user',
'action'     => 'index',
'route_name' => 'user_page',
));
Route::set('sections', '<directory>(/<controller>(/<action>(/<id>)))',
    array(
        'directory' => '(admin|affiliate)'
    ))
    ->defaults(array(
        'controller' => 'shop',
        'action'     => 'index',
    ));
/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'welcome',
		'action'     => 'index',
	));