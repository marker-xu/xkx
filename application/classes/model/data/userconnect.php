<?php 

/**
 * 第三方帐号
 * @author xucongbin
 */
class Model_Data_UserConnect extends Model_Data_MongoCollection
{
	//盛大
	const TYPE_SNDA = 1;
	//围脖
	const TYPE_SINA = 2;
	//qq围脖
	const TYPE_TQQ = 3;
	//人人
	const TYPE_RENREN = 4;
	//豆瓣
	const TYPE_DOUBAN = 5;
	//QQ
	const TYPE_QQ = 6;
	//MSN
	const TYPE_MSN = 7;
	
	//连接类型 -- 登录
	const CONNECT_TYPE_LOGIN = 1;
	//连接类型 -- 绑定
	const CONNECT_TYPE_BIND = 2;
	
	//连接状态 -- 未绑定
	const CONNECT_STATUS_UNBIND = 0;
	//连接状态 -- 绑定
	const CONNECT_STATUS_BIND = 1;
	
	public function __construct()
	{
        parent::__construct('user_connect');
	}
	
	public function get($id)
	{
	    return $this->findOne(array( '_id' => new MongoId($id) ));
	}
	
	public function getMulti($ids) 
	{
		$arrMongoIds = array();
		foreach ($ids as $strTmpId) {
			$arrMongoIds[] = new MongoId($strTmpId);
		}
	    return $this->find(array('_id' => array('$in' => $arrMongoIds)));
	}
	/**
	 * 
	 * 创建新连接
	 * @param string $type
	 * @param int $uid
	 * @param int $c_type 连接类型
	 * @param array $arrParams array(
	 * 	connect_id => 第三方帐号,
	 * 	access_token => array
	 * )
	 */
	public function addConnect($type, $uid, $c_type, array $arrParams) {
		JKit::$log->debug(__FUNCTION__." type-{$type}, uid-{$uid},  params-", $arrParams);
		$arrParams['third_party'] = $type;
		$arrParams['user_id'] = $uid;
		if( !isset($arrParams['create_time']) ) {
			$arrParams['create_time'] = new MongoDate();
		}
		$arrParams['update_time'] = $arrParams['create_time'];
		$arrParams['connect_type'] = $c_type;
		$arrParams['connect_status'] = self::CONNECT_STATUS_BIND;
		try {
			$arrResult = $this->getCollection()->insert($arrParams, true);
		} catch (MongoException $e) {
			JKit::$log->warn("addConnect failure, code-".$e->getCode().", msg-".$e->getMessage().", param-", $arrParams);
			return false;
		}
		
		JKit::$log->debug(__FUNCTION__." result-", $arrResult);
		return isset( $arrResult["ok"] ) && $arrResult["ok"]==1 ? true : false;
	}
	/**
	 * 
	 * 重新绑定操作
	 * @param string $type
	 * @param int $uid
	 * @param array $arrToken
	 * @throws Model_Data_Exception
	 * 
	 * @return boolean
	 */
	public function modifyConnectTokenByUid($type, $uid, $arrToken) {
		
		JKit::$log->debug(__FUNCTION__." type-{$type}, uid-{$uid}, token-", $arrToken);
		if ( !$this->getConnectByUid($type, $uid) ) {
			throw new Model_Data_Exception("at this third_party({$type}), user({$uid}) not exists", NULL, -3002);
		}
		$arrParams = array(
			'access_token' => $arrToken, 
			'connect_status' => self::CONNECT_STATUS_BIND, 
			'update_time' => new MongoDate()
		);
		$query = array(
			"third_party" => $type,
			"user_id" => intval($uid), 
		 );
		try {
			$arrResult = $this->getCollection()->update($query, array('$set'=>$arrParams), array("safe"=>true));
		} catch (MongoException $e) {
			JKit::$log->warn("modifyConnect failure, code-".$e->getCode().", msg-".$e->getMessage().
			", type-{$type}, uid-{$uid} , params-", $arrParams);
			return false;
		}
		JKit::$log->debug(__FUNCTION__." result-", $arrResult);
		return isset($arrResult["ok"]) && $arrResult["ok"]==1 ? true : false;
	}
	
	public function modifyConnectTokenById($id, $arrToken) {
		JKit::$log->debug(__FUNCTION__." id-{$id}, token-", $arrToken);
		if ( !$this->get($id) ) {
			throw new Model_Data_Exception("connect({$id}) not exists", NULL, -3002);
		}
		$arrParams = array(
			'access_token' => $arrToken, 
			'connect_status' => self::CONNECT_STATUS_BIND, 
			'update_time' => new MongoDate()
		);
		$query = array(
			"_id" => new MongoId($id)
		 );
		try {
			$arrResult = $this->getCollection()->update($query, array('$set'=>$arrParams), array("safe"=>true));
		} catch (MongoException $e) {
			JKit::$log->warn("modifyConnect failure, code-".$e->getCode().", msg-".$e->getMessage().
			", id-{$id}, params-", $arrParams);
			return false;
		}
		JKit::$log->debug(__FUNCTION__." result-", $arrResult);
		return isset($arrResult["ok"]) && $arrResult["ok"]==1 ? true : false;
	}
	/**
	 * 取消绑定登录帐号
	 * @param string $type
	 * @param int $uid
	 * @param array $arrToken
	 * @throws Model_Data_Exception
	 * 
	 * @return boolean 
	 * */
	public function unBindByUid($type, $uid) {
		JKit::$log->debug(__FUNCTION__." type-{$type}, uid-{$uid}");
		if ( !$this->getConnectByUid($type, $uid) ) {
			throw new Model_Data_Exception("at this third_party({$type}), user({$uid}) not exists", NULL, -3002);
		}
		$arrParams = array(
			'connect_status' => self::CONNECT_STATUS_UNBIND, 
			'update_time' => new MongoDate(),
		);
		$query = array(
			"third_party" => $type,
			"user_id" => intval($uid), 
		 );
		try {
			$arrResult = $this->getCollection()->update($query, array('$set'=>$arrParams), array("safe"=>true));
		} catch (MongoException $e) {
			JKit::$log->warn("modifyConnect failure, code-".$e->getCode().", msg-".$e->getMessage().
			", type-{$type}, uid-{$uid} , params-", $arrParams);
			return false;
		}
		JKit::$log->debug(__FUNCTION__." result-", $arrResult);
		return isset($arrResult["ok"]) && $arrResult["ok"]==1 ? true : false;
	}
	
	/**
	 * 删除连接 || 取消绑定绑定的帐号
	 * @param string $type
	 * @param int $uid
	 * @throws Model_Data_Exception
	 * 
	 * @return boolean 
	 * */
	
	public function removeConnectByUid($type, $uid) {
		JKit::$log->debug(__FUNCTION__." type-{$type}, uid-{$uid}");
		$query = array(
			"third_party" => $type,
			"user_id" => intval($uid), 
		 );
		try {
			$ret = $this->getCollection()->remove($query);
		} catch (MongoException $e) {
			JKit::$log->warn("removeConnect failure, code-".$e->getCode().", msg-".$e->getMessage().
			", type-{$type}, uid-{$uid}");
			return false;
		}
		JKit::$log->debug(__FUNCTION__." result-", $ret);
		return $ret;
	}
	
	/**
	 * 查询第三方是否绑定到当前用户
	 * @param string $type
	 * @param int $uid
	 * @throws Model_Data_Exception
	 * 
	 * @return array 
	 * */
	
	public function getConnectByUid($type, $uid) {
		JKit::$log->debug(__FUNCTION__." type-{$type}, uid-{$uid}");
		$query = array(
			"user_id" => $uid, 
		    "third_party" => $type,
		 );
		 JKit::$log->debug(__FUNCTION__." result-", $this->find($query));
		 $ret = $this->find($query);
		 $arrRet = empty($ret) ? null : array();
		 foreach($ret as $v)
		 {
		 	$arrRet[] = $v;
		 }
		 return $arrRet;
	}
	/**
	 * 查询第三方是否绑定过登录
	 * @param string $type
	 * @param int $connectId
	 * @param int $connectType 
	 * @throws Model_Data_Exception
	 * 
	 * @return array 
	 * */
	public function getConnectByCid($type, $connectId) {
		$query = array(
			"third_party" => $type,
			"connect_id" => $connectId, 
			"connect_type" => self::CONNECT_TYPE_LOGIN, 
		 );
		 
		 return $this->findOne($query);
	}
	
	/**
	 * 查询用户绑定列表
	 * @param int $uid
	 * @throws Model_Data_Exception
	 * 
	 * @return array 
	 * */
	
	public function getConnectsByUid($uid){
		JKit::$log->debug(__FUNCTION__." uid-{$uid}");
		$query = array(
			"user_id" => $uid, 
		);
		JKit::$log->debug(__FUNCTION__." result-", $this->find($query));
		return $this->find($query);
	
	}
}