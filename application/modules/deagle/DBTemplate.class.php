<?php defined('SYSPATH') or die('No direct script access.');

class DBTemplate {
	/**
	 * 
	 * @var Database
	 */
	protected $database;
	/**
	 * 
	 * @param string $dbConfigName
	 * @param mixed $config
	 */
	public function __construct($dbConfigName, $config=NULL) {
		$this->database = Database::instance($dbConfigName, $config);
	}
	
	/**
	 * query
	 * @param string $sql
	 * @return array
	 * @throws DataAccessException
	 */
	public function query($sql){
	    $query = DB::query(Database::SELECT, $sql);
	    return $query->execute($this->database)->as_array();
	}
	
	/**
	 * insert a record to dbstore
	 * @param string $sql
	 * @return int, the insert id
	 * @throws DataAccessException
	 */
	public function insert($sql){
	    $query = DB::query(Database::INSERT, $sql);
	    return $query->execute($this->database);
	}
	
	/**
	 * execute without return, like update\delete\drop etc.
	 * @param string $sql
	 * @return boolean
	 * @throws DataAccessException
	 */
	public function execute($sql){
	    $query = DB::query(Database::SELECT, $sql);
	    return $query->execute($this->database);
	}
	/**
	 * 
	 * @param string $dbConfigName
	 * @throws DataAccessException
	 * @return Database
	 */
	public static function getInstance($dbConfigName) {
	    static $dbTemplateMap = array();
	    if (!isset($dbTemplateMap[$dbConfigName])) {
	        $dbTemplateMap[$dbConfigName] = Database::instance($dbConfigName);
	    }
	    if ( !($dbTemplateMap[$dbConfigName] instanceof Database) ) {
	        throw new DataAccessException("the database config ({$dbConfigName}) not exists");
	    }
	    return $dbTemplateMap[$dbConfigName];
	}
}