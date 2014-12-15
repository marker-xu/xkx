<?php 

/**
 * 第三方帐号
 * @author xucongbin
 */
class Model_Data_UserConnect {
	//盛大
	const TYPE_BAIDU= 1;
	//围脖
	const TYPE_SINA = 2;
	//qq围脖
	const TYPE_QQ = 3;
	
	//连接类型 -- 登录
	const CONNECT_TYPE_LOGIN = 1;
	//连接类型 -- 绑定
	const CONNECT_TYPE_BIND = 2;
	
	//连接状态 -- 未绑定
	const CONNECT_STATUS_UNBIND = 0;
	//连接状态 -- 绑定
	const CONNECT_STATUS_BIND = 1;
	/**
	 * 
	 * @var UserConnectDAOImpl
	 */
	private $dao;
	
	public function __construct() {
        $this->dao = new UserConnectDAOImpl(array(), null, DBTemplate::getInstance("xkx"));
	}
	/**
	 * 
	 * @param int $id
	 * 
	 * @return UserConnect
	 */
	public function get($id) {
	    return $this->dao->getById($id);
	}
	/**
	 * 
	 * @param array<int> $ids
	 * @return array
	 */
	public function getMulti($ids) {
		if (!$ids) {
	        return array();
	    }
	    $connects = $this->dao->getListByIdList($ids);
	    if ($keepOrder) {
	    }
	    return $users;
	}
	/**
	 * 
	 * 创建新连接
	 * @param string $thirdParty
	 * @param int $userId
	 * @param int $c_type 连接类型
	 * @param array $arrParams array(
	 * 	connect_id => 第三方帐号,
	 * 	access_token => array
	 * )
	 */
	public function addConnect($thirdParty, $userId, $c_type, array $arrParams) {
		JKit::$log->debug(__FUNCTION__." type-{$thirdParty}, uid-{$uid},  params-", $arrParams);
		$arrParams['third_party'] = $thirdParty;
		$arrParams['user_id'] = $uid;
		if( !isset($arrParams['create_time']) ) {
			$arrParams['create_time'] = date("Y-m-d H:i:s");
		}
		$arrParams['connect_type'] = $c_type;
		$arrParams['connect_status'] = self::CONNECT_STATUS_BIND;
		$userConnect = new UserConnect();
		$userConnect->setUserId($userId);
		$userConnect->setThirdParty($thirdParty);
		$userConnect->setConnectId($arrParams["connect_id"]);
		$userConnect->setAccessToken($arrParams["connect_id"]);
		#TODO connect_type
		try {
			$res = $this->dao->insert($userConnect);
		} catch (MongoException $e) {
			JKit::$log->warn("addConnect failure, code-".$e->getCode().", msg-".$e->getMessage().", param-", $arrParams);
			return false;
		}
		
		JKit::$log->debug(__FUNCTION__." result-", $res);
		return $res;
	}
	/**
	 * 
	 * 重新绑定操作
	 * @param string $thirdParty
	 * @param int $uid
	 * @param array $arrToken
	 * @throws Model_Data_Exception
	 * 
	 * @return boolean
	 */
	public function modifyConnectTokenByUid($thirdParty, $uid, $arrToken) {
		return true;
		JKit::$log->debug(__FUNCTION__." type-{$thirdParty}, uid-{$uid}, token-", $arrToken);
		if ( !($userConnect = $this->getConnectByUid($thirdParty, $uid)) ) {
			throw new Model_Data_Exception("at this third_party({$thirdParty}), user({$uid}) not exists", NULL, -3002);
		}
		$userConnect->setAccessToken($arrToken);
		$arrParams = array(
			'access_token' => $arrToken, 
			'connect_status' => self::CONNECT_STATUS_BIND, 
			'update_time' => new MongoDate()
		);
		$query = array(
			"third_party" => $thirdParty,
			"user_id" => intval($uid), 
		 );
		try {
		    $this->dao->update($userConnect);
			$arrResult = $this->getCollection()->update($query, array('$set'=>$arrParams), array("safe"=>true));
		} catch (MongoException $e) {
			JKit::$log->warn("modifyConnect failure, code-".$e->getCode().", msg-".$e->getMessage().
			", type-{$thirdParty}, uid-{$uid} , params-", $arrParams);
			return false;
		}
		JKit::$log->debug(__FUNCTION__." result-", $arrResult);
		return isset($arrResult["ok"]) && $arrResult["ok"]==1 ? true : false;
	}
	
	public function modifyConnectTokenById($id, $arrToken) {
		JKit::$log->debug(__FUNCTION__." id-{$id}, token-", $arrToken);
		if ( !($userConnect = $this->get($id)) ) {
			throw new Model_Data_Exception("connect({$id}) not exists", NULL, -3002);
		}
		$userConnect->setAccessToken($arrToken);
		try {
		    $res = $this->dao->update($userConnect);
		} catch (MongoException $e) {
			JKit::$log->warn("modifyConnect failure, code-".$e->getCode().", msg-".$e->getMessage().
			", id-{$id}, token-", $arrToken);
			return false;
		}
		JKit::$log->debug(__FUNCTION__." result-", $res);
		return $res;
	}
	/**
	 * 取消绑定登录帐号
	 * @param string $thirdParty
	 * @param int $uid
	 * @param array $arrToken
	 * @throws Model_Data_Exception
	 * 
	 * @return boolean 
	 * */
	public function unBindByUid($thirdParty, $uid) {
		JKit::$log->debug(__FUNCTION__." type-{$thirdParty}, uid-{$uid}");
		if ( !$this->getConnectByUid($thirdParty, $uid) ) {
			throw new Model_Data_Exception("at this third_party({$thirdParty}), user({$uid}) not exists", NULL, -3002);
		}
		$arrParams = array(
			'connect_status' => self::CONNECT_STATUS_UNBIND, 
			'update_time' => new MongoDate(),
		);
		$query = array(
			"third_party" => $thirdParty,
			"user_id" => intval($uid), 
		 );
		try {
			$arrResult = $this->getCollection()->update($query, array('$set'=>$arrParams), array("safe"=>true));
		} catch (MongoException $e) {
			JKit::$log->warn("modifyConnect failure, code-".$e->getCode().", msg-".$e->getMessage().
			", type-{$thirdParty}, uid-{$uid} , params-", $arrParams);
			return false;
		}
		JKit::$log->debug(__FUNCTION__." result-", $arrResult);
		return isset($arrResult["ok"]) && $arrResult["ok"]==1 ? true : false;
	}
	
	/**
	 * 删除连接 || 取消绑定绑定的帐号
	 * @param string $thirdParty
	 * @param int $uid
	 * @throws Model_Data_Exception
	 * 
	 * @return boolean 
	 * */
	
	public function removeConnectByUid($thirdParty, $uid) {
		JKit::$log->debug(__FUNCTION__." type-{$thirdParty}, uid-{$uid}");
		$query = array(
			"third_party" => $thirdParty,
			"user_id" => intval($uid), 
		 );
		try {
			$ret = $this->getCollection()->remove($query);
		} catch (MongoException $e) {
			JKit::$log->warn("removeConnect failure, code-".$e->getCode().", msg-".$e->getMessage().
			", type-{$thirdParty}, uid-{$uid}");
			return false;
		}
		JKit::$log->debug(__FUNCTION__." result-", $ret);
		return $ret;
	}
	
	/**
	 * 查询第三方是否绑定到当前用户
	 * @param string $thirdParty
	 * @param int $uid
	 * @throws Model_Data_Exception
	 * 
	 * @return UserConnect 
	 * */
	
	public function getConnectByUid($thirdParty, $uid) {
		JKit::$log->debug(__FUNCTION__." type-{$thirdParty}, uid-{$uid}");
		$condition = array(
	        "third_party=".intval($thirdParty),
	        "user_id=".$uid
		);
		$ret = $this->dao->getList($condition, '', null, 0, 1);
		return $ret ? $ret[0] : null;
	}
	/**
	 * 查询第三方是否绑定过登录
	 * @param unknown $thirdParty
	 * @param unknown $connectId
	 * @return Ambigous <NULL, UserConnect>
	 */
	public function getConnectByCid($thirdParty, $connectId) {
		 
		$condition = array(
	        "third_party=".intval($thirdParty),
	        "connect_id=".$connectId,
		);
		$ret = $this->dao->getList($condition, '', null, 0, 1);
		return $ret ? $ret[0] : null;
	}
	
	/**
	 * 查询用户绑定列表
	 * @param unknown $uid
	 * @return Ambigous <array<UserConnect>, multitype:UserConnect >
	 */
	public function getConnectsByUid($uid){
		$condition = array(
	        "user_id=".intval($uid),
		);
		$ret = $this->dao->getList($condition, '', null, 0, 1);
		return $ret;
	
	}
}