<?php
/**
 * database dao
 * @author jiangchanghua<jiangchanghua@baidu.com>
 * @since 2011-03-21
 * @package holmes.web.module.base
 *
 */
abstract class DatabaseDAO {
    /**
     * self cache
     * @var array
     */
    protected $selfCache;
    /**
     * config
     * @var array
     */
    protected $config;
    /**
     * cache engine
     * @var CacheEngine
     */
    protected $cacheEngine;
    /**
     * DBTemplate
     * @var DBTemplate
     */
    protected $dbTemplate;

    /**
     * __construct
     * @param array $config
     * @param CacheEngine $cacheEngine
     * @param DBTemplate $dbTemplate
     */
    public function __construct($config, $cacheEngine, $dbTemplate=NULL){
        $this->selfCache = array();
        $this->config = $config;
        $this->cacheEngine = $cacheEngine;
        $this->dbTemplate = $dbTemplate;
    }

    /**
     * limit
     * @param string $sql
     * @param int $from
     * @param int $limit
     * @return string $sql
     */
    protected function sqlLimit(&$sql, $from, $limit){
        if ($limit > 0){
            $sql .= ' LIMIT '.$from.','.$limit;
        }
        return $sql;
    }

    /**
     * ordey by
     * @param string $sql
     * @param string $orderBy
     * @param string $order
     * @return string $sql
     */
    protected function sqlOrderBy(&$sql, $orderBy, $order){
        if ($orderBy !== ''){
            $sql .= ' ORDER BY '.$orderBy.' '.$order;
        }
        return $sql;
    }
}
