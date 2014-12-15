<?php
/**
 * abstract class: cache engine
 * @author jiangchanghua
 * @since 2013-03-21
 * @package holmes.web.framework.cache
 * 
 */
abstract class CacheEngine{

    /**
     * config
     * @var array
     */
    protected $config;

    public function __construct($config){
        $this->config = $config;
        $this->init();
    }

    /**
     * init settings
     * @return void
     */
    abstract public function init();

    /**
     * overwrite key
     * @param string $key
     * @return string
     */
    abstract protected function overwriteKey($key);

    /**
     * read a key from cache
     * @param string $key
     * @return mixed
     */
    abstract public function read($key);

    /**
     * write a key to cache
     * @param string $key
     * @param mixed $val
     * @param int $expiredTime
     * @return boolean
     */
    abstract public function write($key, $val, $expiredTime = 0);

    /**
     * delete a key from cache
     * @param string $key
     * @return boolean
     */
    abstract public function delete($key);

    /**
     * clear expired data by default
     * @return boolean
     */
    abstract public function clear();

}
