<?php
/**
 * DAO implementation: UserConnectDAO
 * 
 * @author xucongbin
 * @since 2014-12-10
 * @package xkx
 * @version 1.0.0
 * @copyright Copyright (c) 2014 Baidu.com, Inc. All Rights Reserved.
 * @license Auto generated by Deagle 1.0.0
 */
class UserConnectDAOImpl extends DatabaseDAO implements UserConnectDAO{

    /**
     * delimiter for multiple strings
     */
    const DELIMIT = '###holmes###';

    /**
     * __construct
     * @param array $config
     * @param CacheEngine $cacheEngine
     * @param DBTemplate $dbTemplate
     */
    public function __construct($config, $cacheEngine, $dbTemplate){
        parent::__construct($config, $cacheEngine, $dbTemplate);
    }

    /**
     * insert UserConnect
     * @param UserConnect $userConnect
     * @return UserConnect $userConnect
     * @throws DataAccessException
     */
    public function insert($userConnect){
        $sql = 'INSERT INTO `user_connect` (';
        $fields = array();
        $fields[] = '`id`';
        $fields[] = '`user_id`';
        $fields[] = '`third_party`';
        $fields[] = '`connect_id`';
        $fields[] = '`access_token`';
        $fields[] = '`create_time`';
        $sql .= implode(",", $fields);
        $sql .= ') VALUES (';
        $values = array();
        $values[] = 'NULL';
        $values[] = '"'.StringUtil::mysqlEscape($userConnect->getUserId()).'"';
        $values[] = '"'.StringUtil::mysqlEscape($userConnect->getThirdParty()).'"';
        $values[] = '"'.StringUtil::mysqlEscape($userConnect->getConnectId()).'"';
        $values[] = '"'.StringUtil::mysqlEscape($userConnect->getAccessToken()).'"';
        $values[] = '"'.StringUtil::mysqlEscape($userConnect->getCreateTime()).'"';
        $sql .= implode(',', $values);
        $sql .= ')';
        $id = $this->dbTemplate->insert($sql);
        $userConnect->setId($id);
        return $userConnect;
    }

    /**
     * insert many UserConnect
     * @param array<UserConnect> $userConnectList
     * @return boolean, true on success & false on failed
     * @throws DataAccessException
     */
    public function insertMany($userConnectList){
        $ret = true;
        foreach ($userConnectList as $userConnect){
            $ret = $ret && $this->insert($userConnect);
        }
        return $ret;
    }

    /**
     * update UserConnect
     * @param UserConnect $userConnect
     * @return boolean, true on success & false on failed
     * @throws DataAccessException
     */
    public function update($userConnect){
        $sql = 'UPDATE `user_connect` SET ';
        $set = array();
        $set[] = '`user_id`="'.StringUtil::mysqlEscape($userConnect->getUserId()).'"';
        $set[] = '`third_party`="'.StringUtil::mysqlEscape($userConnect->getThirdParty()).'"';
        $set[] = '`connect_id`="'.StringUtil::mysqlEscape($userConnect->getConnectId()).'"';
        $set[] = '`access_token`="'.StringUtil::mysqlEscape($userConnect->getAccessToken()).'"';
        $set[] = '`create_time`="'.StringUtil::mysqlEscape($userConnect->getCreateTime()).'"';
        $sql .= implode(',', $set);
        $sql .= ' WHERE `id`=';
        $sql .= '"'.StringUtil::mysqlEscape($userConnect->getId()).'"';
        $sql .= ' LIMIT 1';
        return $this->dbTemplate->execute($sql);
    }

    /**
     * update many UserConnect
     * @param array<UserConnect> $userConnectList
     * @return boolean, true on success & false on failed
     * @throws DataAccessException
     */
    public function updateMany($userConnectList){
        $ret = true;
        foreach ($userConnectList as $userConnect){
            $ret = $ret && $this->update($userConnect);
        }
        return $ret;
    }

    /**
     * delete UserConnect
     * @param UserConnect $userConnect
     * @return boolean, true on success & false on failed
     * @throws DataAccessException
     */
    public function delete($userConnect){
        throw new UnImplementException('this method is currently unimplemented');
        $sql = 'DELETE FROM `user_connect` WHERE `id`=';
        $sql .= '"'.StringUtil::mysqlEscape($userConnect->getId()).'"';
        $sql .= ' LIMIT 1';
        return $this->dbTemplate->execute($sql);
    }

    /**
     * delete many UserConnect
     * @param array<UserConnect> $userConnectList
     * @return boolean, true on success & false on failed
     * @throws DataAccessException
     */
    public function deleteMany($userConnectList){
        $ret = true;
        foreach ($userConnectList as $userConnect){
            $ret = $ret && $this->delete($userConnect);
        }
        return $ret;
    }

    /**
     * get by Id
     * @param string $id
     * @return UserConnect $userConnect
     * @throws DataAccessException
     */
    public function getById($id){
        $sql = 'SELECT * FROM `user_connect` WHERE `id`=';
        $sql .= '"'.StringUtil::mysqlEscape($id).'"';
        $sql .= ' LIMIT 1';
        $instance = NULL;
        $ret = $this->dbTemplate->query($sql);
        if (count($ret) > 0){
            $instance = $this->build($ret[0]);
        }
        return $instance;
    }

    /**
     * get list by id list
     * @param array<int> $idList
     * @return array<UserConnect> $userConnectList
     * @throws DataAccessException
     */
    public function getListByIdList($idList){
        if (count($idList) < 1){
            return array();
        }
        $sql = 'SELECT * FROM `user_connect` WHERE `id` IN ';
        $tmpIdList = array();
        foreach ($idList as $id){
            $tmpIdList[] = '"'.StringUtil::mysqlEscape($id).'"';
        }
        $sql .= '('.implode(',', $tmpIdList).')';
        $list = array();
        $ret = $this->dbTemplate->query($sql);
        if (count($ret) > 0){
            foreach ($ret as $row){
                $list[] = $this->build($row);
            }
        }
        return $list;
    }


    /**
     * get list by condition
     * @param array $condition
     * @param string $orderBy
     * @param string $order
     * @param int $offset
     * @param int $limit
     * @return array<UserConnect> $UserConnectList
     * @throws DataAccessException
     */
    public function getList($condition, $orderBy, $order, $offset, $limit){
        $sql = 'SELECT * FROM `user_connect` WHERE ';
        $sql .= implode(' AND ', $condition);
        $this->sqlOrderBy($sql, $orderBy, $order);
        $this->sqlLimit($sql, $offset, $limit);
        $list = array();
        $ret = $this->dbTemplate->query($sql);
        if (count($ret) > 0){
            foreach ($ret as $row){
                $list[] = $this->build($row);
            }
        }
        return $list;
    }

    /**
     * get count by condition
     * @param array $condition
     * @return int $count
     * @throws DataAccessException
     */
    public function getCount($condition){
        $sql = 'SELECT count(1) as cnt FROM `user_connect` WHERE ';
        $sql .= implode(' AND ', $condition);
        $ret = $this->dbTemplate->query($sql);
        return $ret[0]['cnt'];
    }

    /**
     * get list by user-defined sql
     * @param string $sql
     * @return array<UserConnect> $userConnectList
     * @throws DataAccessException
     */
    public function getListBySql($sql){
        $list = array();
        $ret = $this->dbTemplate->query($sql);
        if (count($ret) > 0){
            foreach ($ret as $row){
                $list[] = $this->build($row);
            }
        }
        return $list;
    }

    /**
     * build a/an UserConnect from db record
     * @param array $row
     * @return UserConnect $userConnect
     */
    public function build($row){
        $userConnect = new UserConnect();
        $userConnect->setId($row['user_connect.id']);
        $userConnect->setUserId(trim($row['user_connect.user_id']));
        $userConnect->setThirdParty(trim($row['user_connect.third_party']));
        $userConnect->setConnectId(trim($row['user_connect.connect_id']));
        $userConnect->setAccessToken(trim($row['user_connect.access_token']));
        $userConnect->setCreateTime(trim($row['user_connect.create_time']));
        return $userConnect;
    }

}
