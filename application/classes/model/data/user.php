<?php 

/**
 * 用户
 * @author xucongbin
 */
class Model_Data_User {
    /**
     * 
     * @var UserItemDAOImpl
     */
    private $userItemDao;
    /**
     * return void
     */
	public function __construct() {
	    $this->userItemDao = new UserItemDAOImpl(array(), null, DBTemplate::getInstance("xkx"));
	}

	/**
	 * 查询单个用户的信息
	 * @param string $id
	 * @return array|null
	 */
	public function get($id) {
	    return $this->userItemDao->getById($id);
	}
	
	/**
	 * 查询多个用户的信息
	 * @param array $ids
	 * @param bool $keepOrder 是否保持传入参数中ID的顺序
	 * @return array
	 */
	public function getMulti($ids, $keepOrder = false) {
	    if (!$ids) {
	        return array();
	    }
	    $users = $this->userItemDao->getListByIdList($ids);
	    if ($keepOrder) {
	    }
	    return $users;
	}
	
	/**
	 * 根据昵称查询多个用户的信息
	 * @param array $arrNick
	 * @param bool $keepOrder 是否保持传入参数中ID的顺序
	 * @return array
	 */
	public function getMultiByNick($arrNick, $fields = array()) {
	    if (empty($arrNick)) {
	        return array();
	    }
	    $arrNick = array_map(array("StringUtil", "mysqlEscape"), $arrNick);
	    $condition = array("nick in ('".implode("','", $arrNick)."')");
	    $users = $this->userItemDao->getList($condition, '', null, 0, 0);

	    return $users;
	}
		
	/**
	 * 
	 * @param string $email
	 * @param array $arrParams
	 * @return boolean|number
	 */
	public function addUser($email, array $arrParams) {
		JKit::$log->debug(__FUNCTION__." email-{$email}, params-", $arrParams);
		
		if( !isset($arrParams['nick']) ) {
			$arrParams['nick'] = $email;
		}
		if( !isset($arrParams['create_time']) ) {
			$arrParams['create_time'] = date("Y-m-d H:i:s");
		}
		
		if( !isset($arrParams['last_login_ip']) ) {
			$arrParams['last_login_ip'] = Request::$client_ip;
		}
		if( !isset($arrParams['is_email_verified']) ) {
			$arrParams['is_email_verified'] = UserItem::EmailVerifiedNo;
		}
		if( !isset($arrParams['tags']) ) {
			$arrParams['tags'] = array();
		}
		if( !isset($arrParams['accept_subscribe_email']) ) {
			$arrParams['accept_subscribe_email'] = 1;
		}
		$userItem = new UserItem();
		$userItem->setEmail(strtolower($email));
		$userItem->setNick($arrParams['nick']);
		$userItem->setCreateTime($arrParams['create_time']);
		$userItem->setLastLoginTime($arrParams['create_time']);
		$userItem->setIsEmailVerified($arrParams['is_email_verified']);
		$userItem->setTags($arrParams['tags']);
		$userItem->setAcceptSubscribeEmail($arrParams['accept_subscribe_email']);
		try {
		    $res = $this->userItemDao->insert($userItem);
		} catch (Kohana_Database_Exception $e) {
			JKit::$log->warn("addUser failure, code-".$e->getCode().", msg-".$e->getMessage().", param-", $arrParams);
			
			return false;
		}
		JKit::$log->debug(__FUNCTION__." result-", $res);
		if($res) {
			return $res;
		}
		
		return false;
	}
	/**
	 * 
	 * Enter description here ...
	 * @param string $email
	 * @param int $excludeId
	 * @return 
	 */
	public function getByEmail($email, $excludeId=NULL) {
	    $condition = array("email= '". StringUtil::mysqlEscape($email)."'");
	    if ($excludeId) {
	        $condition[] = array("id!=".intval($excludeId));
	    }
	    $users = $this->userItemDao->getList($condition, '', null, 0, 1);

	    return $users[0];
	}
	/**
	 * 
	 * Enter description here ...
	 * @param string $nick
	 * @param int $excludeId
	 */
	public function getByNick($nick, $excludeId=NULL) {
	    $condition = array("nick= '". StringUtil::mysqlEscape($nick)."'");
	    if ($excludeId) {
	        $condition[] = array("id!=".intval($excludeId));
	    }
	    $users = $this->userItemDao->getList($condition, '', null, 0, 1);
	    
	    return $users[0];
	}
	/**
	 * 更新用户信息
	 * @param int $uid
	 * @param UserItem $userItem
	 * @throws Model_Data_Exception
	 * @return boolean
	 */
	public function modifyById($uid, $userItem) {
	    
		JKit::$log->debug(__FUNCTION__." uid-{$uid}, params-", (array)$userItem);
		if ( !$this->get($uid) ) {
			throw new Model_Data_Exception("user({$uid}) not exists", -3001, NULL);
		}
		$userItem->setId($id);
		$query = array("_id" => intval($uid) );
		try {
			$res = $this->userItemDao->update($userItem);
		} catch (Kohana_Database_Exception $e) {
			JKit::$log->warn("modifyUser failure, code-".$e->getCode().", msg-".$e->getMessage().", uid-{$uid}, param-", (array)$userItem);
		}
		JKit::$log->debug(__FUNCTION__." result-", $res);
		return $res;
	}
	
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $fileName 图片路径
	 * 
	 * @return boolean|array(
	 * 	'group_name' => 组名,
	 * 	'filename' =>图片存储相对路径
	 * )
	 */
	public static function uploadAvatar($fileName, $ext=NULL) {
		JKit::$log->debug(__FUNCTION__." file-{$fileName}");
		$fdfs = new FastDFS(FASTDFS_CLUSTER_USER_AVATAR);
		$ret = $fdfs->storage_upload_by_filename($fileName, $ext);
		JKit::$log->debug(__FUNCTION__." errno-".$fdfs->get_last_error_no().", msg-".$fdfs->get_last_error_info().", ret-", $ret);
		return $ret;
	}
	/**
	 * 
	 * 删除头像
	 * @param string $groupName
	 * @param string $fileName
	 * 
	 * @return boolean
	 */
	public static function removeAvatar($groupName, $fileName) {
		JKit::$log->debug(__FUNCTION__." group-{$groupName}, file-{$fileName}");
		$fdfs = new FastDFS(FASTDFS_CLUSTER_USER_AVATAR);
		$ret = $fdfs->storage_delete_file($groupName, $fileName);
		JKit::$log->debug(__FUNCTION__." errno-".$fdfs->get_last_error_no().", msg-".$fdfs->get_last_error_info().", ret-".$ret);
		return $ret;
	}
}