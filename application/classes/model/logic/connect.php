<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 第三方登录和绑定
 * @author xucongbin zhangjianbin
 */
class Model_Logic_Connect extends Model {
	
	private $objModelConnect;
	
	private $objLogicUser;
	
	public function __construct() {
		
		$this->objModelConnect = new Model_Data_UserConnect();
		$this->objLogicUser = new Model_Logic_User();
	}
	
	public function sinaCallback($code,$redirect_uri){
        $this->initConnectApiModel(Model_Data_UserConnect::TYPE_SINA);
		//Model_Sina::debug(true);
		
		if(!( $tokenTmp = Model_Sina::getAccessToken('code',array('code'=>$code,'redirect_uri'=>$redirect_uri)) ))
	    {
	    	return array('err'=>true);
	        //throw new Model_Logic_Exception(__FUNCTION__.'获取Access Token失败。', -4001);
	    }
        $oauth_id = Model_Sina::getParam(Model_Sina::OAUTH_USER_ID);
        $uinfo = Model_Sina::call('users/show',array('uid'=>$oauth_id));
		if(!isset($uinfo['name'])){
			JKit::$log->warn(__FUNCTION__." Model_Sina::call users/show uid-{$oauth_id}, code-{$code},".
				"redirect_uri-{$redirect_uri},ret-",$uinfo);
        	return array('err'=>true,'data'=>$uinfo);
        }
        return array( 
        	'bindUser' => array(
            	'id' => $oauth_id,
                'name' => $uinfo['name'],
        		'avatar' => $uinfo['avatar_large'],
            ),
            'token' => array(
            	'access_token'=> Model_Sina::getParam (Model_Sina::ACCESS_TOKEN) ,
            	'refresh_token' => Model_Sina::getParam (Model_Sina::REFRESH_TOKEN),
            	'expires_in' => Model_Sina::getParam(Model_Sina::EXPIRES_IN),
            )
        );
	}	
	
	public function getSinaRedirectUrl($strCallBackUrl){
	    $this->initConnectApiModel(Model_Data_UserConnect::TYPE_SINA);
		//Model_Sina::debug(true);

		$callback = $strCallBackUrl.URL::query(array(
        	'type' => Model_Data_UserConnect::TYPE_SINA,
		));
	    $url = Model_Sina::getAuthorizeURL($callback, 'code', 'state');
	    
		return $url;
	}
	
	/**
	 * 新浪微博分享
	 * */
	public function sinaShare($param, $access_token){
	    $this->initConnectApiModel(Model_Data_UserConnect::TYPE_SINA);
		Model_Sina::setParam( Model_Sina::ACCESS_TOKEN , $access_token);
		/*$ret = Model_Sina::call('statuses/upload_url_text',array(
			'status'=>urlencode($param['content']),
			'url' => $param['pic_url'],
		), 'POST');*/
		/*$ret = Model_Sina::call('statuses/update',array(
		        'status' => $param['content'],
		    ), 'POST'
		);
		*/
		$pic_url = trim($param['pic_url']);
		$pic_content = file_get_contents($pic_url);
		$pic_file = "/tmp/".uniqid("pic_url").".jpg";
		if(!file_put_contents($pic_file, $pic_content)){
			JKit::$log->warn("Unable to generate the file in the temporary location , file-".$pic_file.
				"source-".$pic_url);
		}else{
			$ret = Model_Sina::call('statuses/upload',array(
			        'status' => trim($param['content']),
			    ), 'POST', array(
			    	'pic'=> $pic_file
			    )
			);
		}

    
        if(isset($ret['error'])){
        	JKit::$log->warn(__FUNCTION__." Model_Sina::call statuses/upload_url_text status-{$param['content']}, ".
        		"pic-{$param['pic_url']} ,access_token-{$access_token},ret-",$ret);
        	return false;
        }
        return true;
	}
	
	/**
	 * 
	 * QQ连接 
	 * @param $code
	 * @param $redirect_uri
	 * 
	 * @return 
	 */
	public function qqCallback($code, $redirect_uri){
        $this->initConnectApiModel(Model_Data_UserConnect::TYPE_QQ);
		//Model_Qq::debug(true);
		$ret = Model_Qq::getAccessToken("code",
			array(
				'code'=>$code, 
				'redirect_uri'=>$redirect_uri,
				'state'=>'state'
			)
		);
		JKit::$log->debug(__FUNCTION__." Model_Qq::getAccessToken code-{$code},ret-", $ret);
		if( !$ret  ) {
	    	return array('err'=>true);
	    }
	    
        $strAccessToken = Model_Qq::getParam(Model_Qq::ACCESS_TOKEN);
        $intOpenId = Model_Qq::getParam(Model_Qq::OPENID);
        $uinfo = Model_Qq::call('user/get_user_info',array('openid'=>$intOpenId));
        JKit::$log->debug(__FUNCTION__." Model_Qq::call user/get_user_info uid-{$intOpenId}".
			", code-{$code}, ret-", $uinfo);
		if(!isset($uinfo['nickname'])){
			JKit::$log->warn(__FUNCTION__." Model_Qq::call user/get_user_info uid-{$intOpenId}".
			", code-{$code},redirect_uri-{$redirect_uri},ret-", $uinfo);
        	return array('err'=>true,'data'=>$uinfo);
        }
        return array( 
        	'bindUser' => array(
            	'id' => $intOpenId,
                'name' => $uinfo['nickname'],
        		'avatar' => isset($uinfo['figureurl_2']) ? $uinfo['figureurl_2'] : ""
            ),
            'token' => array(
            	'access_token'=> Model_Qq::getParam (Model_Qq::ACCESS_TOKEN) ,
            	'refresh_token' => Model_Qq::getParam (Model_Qq::REFRESH_TOKEN),
            	'expires_in' => Model_Qq::getParam(Model_Qq::EXPIRES_IN),
            )
        );
	}	
	/**
	 * 
	 * Enter description here ...
	 * @param string $strComment
	 * @param string $strUrl
	 * @param string $strPic
	 * @param int $uid
	 * @param array $arrExtraParams array(
	 * 	title => 内容标题,
	 * 	summary => 内容简介
	 * )
	 * @param mixed $accessToekn
	 */
	public function qqShare( $strComment, $strUrl, $strPic, $arrExtraParams, $accessToken=null, $uid=NULL ) {
		$this->initConnectApiModel(Model_Data_UserConnect::TYPE_QQ);
		$arrParams = array(
			"site" => DOMAIN_SITE,
//			"nswb" => 1,
			"type" => 4,
			"source" => $this->getAgentType( ),
			"url" => $strUrl,
			"comment" => mb_strimwidth( $strComment, 0, 40),
			"images" => $strPic
		);
		$arrParams = array_merge($arrParams, $arrExtraParams);
		if( isset($arrParams['title']) ) {
			$arrParams['title'] = mb_strimwidth( $arrParams['title'], 0, 36);
		}
		if( isset($arrParams['summary']) ) {
			$arrParams['summary'] = mb_strimwidth( $arrParams['summary'], 0, 80);
		}
		if($accessToken===NULL) {
			$arrConnectInfo = $this->getBindConnectInfo($uid, Model_Data_UserConnect::TYPE_QQ);
			if(!$arrConnectInfo) {
				return false;
			}
			$accessToken = $arrConnectInfo['access_token']['access_token'];
		}
		
		Model_Tqq::setParam( Model_Qq::ACCESS_TOKEN , $accessToekn);
		$ret = Model_Qq::call('share/add_share', $arrParams, 'POST');
		JKit::$log->debug(__FUNCTION__." share/add_share uid-{$uid}, access_token-{$accessToken}, param-".
        		json_encode($arrParams).", ret-", $ret);
        if($ret['ret'] != 0) {
        	JKit::$log->warn(__FUNCTION__." share/add_share uid-{$uid}, access_token-{$accessToken}, param-".
        		json_encode($arrParams).", ret-", $ret);
        	return false;
        }
        return true;
	}
	
	public function getQqRedirectUrl($strCallBackUrl){
	    $this->initConnectApiModel(Model_Data_UserConnect::TYPE_QQ);
		//Model_Sina::debug(true);

		$callback = $strCallBackUrl.URL::query(array(
        	'type' => Model_Data_UserConnect::TYPE_QQ,
		));
	    $url = Model_Qq::getAuthorizeURL($callback, 'code', 'state', 'default', 
	    	'get_user_info,add_share,add_pic_t');
	    
		return $url;
	}
	
	
	/**
	 * 第三方登录
	 * 
	 * @param int $connectType
	 * @param array $bindUser array('id' => ,'name' => )
	 * @param array $accessToken
	 * 
	 * return array
	 * */
	public function login($connectType, $bindUser, $accessToken){
		JKit::$log->debug(__FUNCTION__." connectType-{$connectType}, bindUser-{$bindUser['id']}, accessToken-", 
			$accessToken);
		$arrReturn = array(
			'uid'=>null,
			'isfirstLogin'=>false,
		);
		//是否为第三方创建帐号
		$row = $this->objModelConnect->getConnectByCid($connectType, $bindUser['id']);

        if (!empty($row)) {
        	$intSdid = (int) $row['user_id'];
            // 已经创建，更新Access Token
            $this->objModelConnect->modifyConnectTokenByUid($connectType, $intSdid, $accessToken);
            //获取用户数据
            $arrUserInfo = $this->objLogicUser->getUserByid($intSdid);
            
            if($arrUserInfo) {
				$this->objLogicUser->login($intSdid);
			}
            $arrReturn['uid'] = $intSdid;
            
        } else {
            
        	//创建帐号
        	$sndaParam = array(
        		'AccountId'=>$bindUser["id"],
        		'CompanyId'=>$connectType,
        	);
        	$strNick = $bindUser["name"];
        	$arrAvatar = array();
        	if(isset($bindUser['avatar'])) {
        	    $arrAvatar["org"] = $bindUser['avatar'];
        	}
        	try {
        	    $intSdid = $this->objLogicUser->register("", $bindUser["id"], $strNick, $arrAvatar );
        	} catch (Model_Logic_Exception $e) {
        	    if( $e->getCode()==-2002 ) {
        	        $strNick = $connectType."_".$bindUser["id"];
        	        $intSdid = $this->objLogicUser->register("", $bindUser["id"], $strNick, $arrAvatar );
        	    }
        	}
        	//盛大第三方帐号自动创建
        	if($intSdid){
        	    //绑定头像
				if(isset($bindUser['avatar'])) {
					Session::instance()->set('avatar', $bindUser['avatar']);
				}
        	
	        	//创建登录连接
	        	$c_type = Model_Data_UserConnect::CONNECT_TYPE_LOGIN; 
	        	$isCreate = $this->objModelConnect->addConnect($connectType, $intSdid, $c_type, array(
	                	'connect_id' => $bindUser['id'],
	                	'access_token' => $accessToken,
	        			'connect_type' => Model_Data_UserConnect::CONNECT_TYPE_LOGIN,
	                ));
	        	$arrReturn['isfirstLogin'] = true;
	        	$arrReturn['uid'] = $intSdid;
        	}else{
        		JKit::$log->warn("AutoBindThirdAccountLogin response failure, ret-", $intSdid);
				return false;
        	}
        }
        JKit::$log->debug(__FUNCTION__." result-", $arrReturn);
		return $arrReturn;
	}
	
	public function bind($uid, $connectType, $bindUser, $accessToken){
		JKit::$log->debug(__FUNCTION__."uid-{$uid} ,connectType-{$connectType}".
			", bindUser-{$bindUser['id']}, accessToken-",$accessToken);
		
		//是否绑定过当前用户
		$row = $this->objModelConnect->getConnectByUid($connectType, $uid);
		if ($row) {
            // 已经绑定过，更新状态
            $ret = $this->objModelConnect->modifyConnectTokenByUid($connectType, $uid, $accessToken);

        } else {
            // 没有绑定过，创建绑定
            $c_type = Model_Data_UserConnect::CONNECT_TYPE_BIND; 
            $ret = $this->objModelConnect->addConnect($connectType, $uid, $c_type, array(
                'connect_id' => $bindUser['id'],
                'access_token' => $accessToken
            ));
        }
        JKit::$log->debug(__FUNCTION__." result-", $ret);
		return $ret;
	}
	/**
	 * 取消绑定
	 * */
	public function unBind($connectType, $uid){
		JKit::$log->debug(__FUNCTION__."uid-{$uid} ,connectType-{$connectType}");
		$row = $this->objModelConnect->getConnectByUid($connectType, $uid);
		$ret = null;
		if($row)
		{
			if($row[0]['connect_type'] == Model_Data_UserConnect::CONNECT_TYPE_LOGIN)
			{
				//绑定登录的帐号
				$ret = $this->objModelConnect->unBindByUid($connectType, $uid);
			}else{
				$ret = $this->objModelConnect->removeConnectByUid($connectType, $uid);
			}
		}
        JKit::$log->debug(__FUNCTION__." result-", $ret);
		return $ret;
	}
	
	public function getBindList($uid){
		$arrConnectList = $this->objModelConnect->getConnectsByUid($uid);
		JKit::$log->debug(__FUNCTION__." ConnectList-", $arrConnectList);
		$bindlist = array(
			'sina'=> array(
				'connect_status' => 0,
			),
			'tqq' => array(
				'connect_status' => 0,
			),
		);
		foreach($arrConnectList as $key=>$val){
			if($val['third_party'] == Model_Data_UserConnect::TYPE_SINA){
				$bindlist['sina'] = $val;
				$bindlist['sina']['time'] = date('Y年m月d日',$val['update_time']->sec);
				$bindlist['sina']['expire_time'] = $val['update_time']->sec+$val['access_token']["expires_in"];
				$bindlist['sina']['access_token'] = $val['access_token'];
			}
			if($val['third_party'] == Model_Data_UserConnect::TYPE_TQQ){
				$bindlist['tqq'] = $val;
				$bindlist['tqq']['time'] = date('Y年m月d日',$val['update_time']->sec);
				$bindlist['tqq']['access_token'] = $val['access_token'];
			}
		}
		return $bindlist;
	}
	/**
	 * 
	 * 获取绑定的那个row
	 * @param int $uid
	 * @param int $thirdParty 第三方类型
	 * 
	 * @return array
	 */
	public function getBindConnectInfo( $uid, $thirdParty ) {
		$arrReturn = array();
		$arrUserConnect = $this->objModelConnect->getConnectByUid($thirdParty, $uid);
		if( !$arrUserConnect ) {
			return $arrReturn;
		}
		$intLength = count($arrUserConnect);
		$arrConnectInfo = array_shift($arrUserConnect);
		if( $arrConnectInfo["connect_type"]==Model_Data_UserConnect::CONNECT_TYPE_BIND 
		|| $intLength==1 ) {
			return $arrConnectInfo;
		}
		return array_shift($arrUserConnect);
	}
	/**
	 * 
	 * 检查是否允许使用
	 * @param int $connectType
	 * @param boolean $isLogin 
	 * 
	 * @return boolean
 	 */
	private function checkModIsAllowUse($connectType, $isLogin=true) {
		$arrWhitelist = array(
			Model_Data_UserConnect::TYPE_DOUBAN => array(
				'is_login' => true,
				'is_bind' => false
			),
			Model_Data_UserConnect::TYPE_QQ => array(
				'is_login' => true,
				'is_bind' => false
			),
			Model_Data_UserConnect::TYPE_RENREN => array(
				'is_login' => true,
				'is_bind' => false
			),
			Model_Data_UserConnect::TYPE_SINA => array(
				'is_login' => true,
				'is_bind' => true
			),
			Model_Data_UserConnect::TYPE_TQQ => array(
				'is_login' => true,
				'is_bind' => true
			),
		);
		
		if( !isset($arrWhitelist[$connectType]) ) {
			return false;
		}
		return $isLogin ? $arrWhitelist[$connectType]['is_login'] : $arrWhitelist[$connectType]['is_bind'];
	}
	/**
	 * 
	 * 根据agent返回
	 * @param string $strAgent
	 * 
	 * @return int
	 */
	private function getAgentType( $strAgent=null ) {
		if($strAgent===NULL) {
    		$strAgent = $_SERVER['HTTP_USER_AGENT'];
    	}
    	$strAgent = strtolower($strAgent);
    	$intType = 1;
		if (strstr($strAgent, 'iphone')) {
			$intType = 4;
		} elseif (strstr($strAgent, 'ipad')) {
			$intType = 5;
		} 
		
		return $intType;
	}
	/**
	 * 
	 * 初始化model
	 * @param string $thirdParty
	 */ 
    private function initConnectApiModel( $thirdParty ) {
    	$arrThirdPartyToModelMap = array(
    		Model_Data_UserConnect::TYPE_DOUBAN => array(
    			"config" => "connect.douban",
    			"class" => "Model_Douban"
    		),
    		Model_Data_UserConnect::TYPE_QQ => array(
    			"config" => "connect.qq",
    			"class" => "Model_Qq"
    		),
    		Model_Data_UserConnect::TYPE_RENREN => array(
    			"config" => "connect.renren",
    			"class" => "Model_Renren"
    		),
    		Model_Data_UserConnect::TYPE_SINA => array(
    			"config" => "connect.sina",
    			"class" => "Model_Sina"
    		),
    		Model_Data_UserConnect::TYPE_TQQ => array(
    			"config" => "connect.tqq",
    			"class" => "Model_Tqq"
    		),
    		Model_Data_UserConnect::TYPE_MSN => array(
    			"config" => "connect.msn",
    			"class" => "Model_Msn"
    		),
    	);
    	if( !isset($arrThirdPartyToModelMap[$thirdParty]) ) {
    		throw new Model_Logic_Exception();
    	}
    	$arrConfig = $arrThirdPartyToModelMap[$thirdParty];
    	$config = Kohana::$config->load($arrConfig['config']);
    	call_user_func_array(array($arrConfig['class'], "init"), array($config['app']['id'], $config['app']['secret']));
    }
}