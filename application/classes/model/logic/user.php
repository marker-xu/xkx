<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 用户、第三方帐号、用户视频关系等页面逻辑
 * @author xucongbin
 */
class Model_Logic_User extends Model
{
    public static $basicFields = array('email', 'is_email_verified', 'nick', 'avatar', 'intro');
    
	protected $objModelUser;
	
	public function __construct() {
		$this->objModelUser = new Model_Data_User();
	}
	
	/**
	 * 查询单个用户的基本信息，以及统计信息
	 * @param string $id
	 * @param bool $isNeedStat 是否带上统计信息
	 * @return array|null
	 */
	public function get($id, $isNeedStat=true)
	{
	    $modelDataUser = new Model_Data_User();
	    Profiler::startMethodExec();
	    $user = $modelDataUser->get($id);
		Profiler::endMethodExec(__FUNCTION__.' get');
	    
	    
	    return $user;
	}
	
	/**
	 * 查询多个用户的基本信息，以及统计信息
	 * @param array $ids
	 * @param bool $keepOrder 是否保持传入参数中ID的顺序
	 * @param bool $isNeedStat 是否带上统计信息
	 * 
	 * @return array
	 */
	public function getMulti($ids, $keepOrder = false, $isNeedStat=true) 
	{
	    $modelDataUser = new Model_Data_User();
	    $users = $modelDataUser->getMulti($ids, self::$basicFields);
	    $userIds = Arr::pluck($users, '_id');
	    if (!$userIds) {
	        return array();
	    }
	    
        if ($keepOrder) {
	        $tmp = array();
	        foreach ($ids as $id) {
	            if (isset($users[$id])) {
	                $tmp[$id] = $users[$id];
	            }
	        }
	        $users = $tmp;
	    }
	    
	    return $users;
	}
	
	/**
	 * 用户注册
	 * @param string $email
	 * @param string $passwd
	 * @param string $nick
	 * @param array $avatar 头像地址，通过上传接口，拼好的数据,groupXX/filename;
	 *  array(
	 * 	'org' => 原始图,
     *  160 => 120*120的缩略图
     *  48 => 48*48的缩略图
     *  30 => 30*30的缩略图
	 * )
	 * @param array $extra array(
	 * 	'intro' => 简介
	 * )
	 * @throws Model_Logic_Exception -2002昵称重复
	 * 
	 * @return uid|boolean
	 */
	public function register($email, $passwd, $nick, $avatar, $extra=array()) {
/*
 * 现在邮箱不要求必填，不要求唯一了
 *  		if( !$email ) {
			throw new Model_Logic_Exception("email is emtpy", -2005, NULL);
		}
		
		if ( $email && $this->objModelUser->getByEmail($email) ) {
			throw new Model_Logic_Exception("email exists", -2001, NULL);
		} */
		
		if ( $nick && $this->objModelUser->getByNick($nick) ) {
			throw new Model_Logic_Exception("nick exists", -2002, NULL);
		}
		$salt = $_SERVER['REQUEST_TIME'];
		$arrParams = array(
			'password' => md5($passwd.$salt),
			'nick' => $nick,
			'avatar' => $avatar ,
			'create_time' => new MongoDate($_SERVER['REQUEST_TIME'])
		);
		$arrParams = array_merge($arrParams, $extra);
		$ret = $this->objModelUser->addUser($email, $arrParams);
		if($ret) {
		    $this->login($ret, true);
		}
		return $ret;
	}
	/**
	 * 
	 * 用户登录，生成session，记录feed
	 * @param int $uid
	 * @param bool $bolFromMaster 是否从数据库主库查询 
	 */
    public function login($uid, $bolFromMaster = FALSE) {
    	$user = Session::instance()->get('user');
    	if( isset($user['_id']) && $user['_id']==$uid ) {
    		return true;
    	}
		$userInfo = $this->getUserByid($uid, $bolFromMaster);
		if ($userInfo) {
		    Session::instance()->set('user', $userInfo);
		    $this->objModelUser->modifyById($uid, array(
		        'last_login_time' => new MongoDate(),
		        'last_login_ip' => Request::$client_ip
		    ));
		    #TODO connect
		    
		    return true;
		} 
		return false;
    }
   /**
    * 
    * Enter description here ...
    * @param $uid
    * @param $arrParams
    * @throws Model_Logic_Exception -2002昵称重复, 
    * 
    * @return boolean
    */
    public function modifyUser($uid, $arrParams) {
    	if ( isset($arrParams['nick']) && 
    	$this->objModelUser->getByNick($arrParams['nick'], $uid) ) {
    		throw new Model_Logic_Exception("nick exists", -2002, NULL);
    	}
    	if( isset($arrParams['password']) ) {
    		$userInfo = $this->objModelUser->get($uid, array( "create_time" ));
    		$arrParams['password'] = md5($arrParams['password'].$userInfo['create_time']->sec);
    	}

    	return $this->objModelUser->modifyById($uid, $arrParams);
    }
    /**
     * 
     * 换头像
     * @param int $uid
     * @param string $org
     * @param array $arrThumnil
     * 
     * @return boolean
     */
    public function changeAvatar($uid, $org, $arrThumnil) {
    	$arrUserInfo = $this->objModelUser->get($uid);
    	if (!$arrUserInfo) {
    		return false;
    	}
    	$avatarOrgReturn = Model_Data_User::uploadAvatar($org, "png");
    	if ( !$avatarOrgReturn ) {
    		return false;
    	}
    	
    	$avatar = array(
    		"org" => $avatarOrgReturn['group_name']."/".$avatarOrgReturn['filename']
    	);
    	@unlink($org);
    	$arrThumnilTmp = array();
    	foreach($arrThumnil as $k=>$thumbTmp) {
    		$tmpThumnilReturn = Model_Data_User::uploadAvatar($thumbTmp, "png");
    		if($tmpThumnilReturn) {
    			$avatar[$k] = $tmpThumnilReturn['group_name']."/".$tmpThumnilReturn['filename'];
    			$arrThumnilTmp[] = $tmpThumnilReturn;
    		}
    		@unlink($thumbTmp);
    	}
    	
    	$res = $this->modifyUser($uid, array('avatar' => $avatar));
    	if(!$res) {
    		Model_Data_User::removeAvatar($avatarOrgReturn['group_name'], $avatarOrgReturn['filename']);
    		foreach($arrThumnilTmp as $arrTmp) {
    			Model_Data_User::removeAvatar($arrTmp['group_name'], $arrTmp['filename']);
    		}
    	} else {
    		if( $arrUserInfo['avatar'] && is_array($arrUserInfo['avatar'])) {
    			$arrTmp = array();
    			foreach($arrUserInfo['avatar'] as $val) {
    				$arrTmp = explode("/", $val, 2);
    				Model_Data_User::removeAvatar($arrTmp[0], $arrTmp[1]);
    			}
    		}
    	}
    	
    	return $res;
    }
    
    /**
     * 
     * 退出，毁灭session，添加feed
     * @param int $uid
     */
	public function logout($uid)
	{
		Session::instance()->destroy();
	}
	/**
	 * 
	 * 更新session
	 * @param unknown_type $uid
	 */
	public function changeSession($uid) {
		$userInfo = $this->getUserByid($uid, true);
		if ($userInfo) {
		    Session::instance()->set('user', $userInfo);
		    
		    return true;
		} 
		return false;
	}
    /**
     * 
     * 获取用户信息
     * @param int $uid
     * @param bool $bolFromMaster 从主库查询
     * 
     * @reutrn array|boolean
     */
    public function getUserByid($uid, $bolFromMaster = FALSE) {
        if ($bolFromMaster) {
            $this->objModelUser->setSlaveOkay(false);
        }
    	$userInfo = $this->objModelUser->get($uid);
    	if($userInfo) {
    		$userInfo['create_time'] = $userInfo['create_time']->sec;
    		$userInfo['update_time'] = $userInfo['update_time']->sec;
    		$userInfo['last_login_time'] = $userInfo['last_login_time']->sec;
    	}
    	return $userInfo;
    }
    
    public function getMultiUserByIds($arrUids) {
    	$arrUserList = $this->objModelUser->getMulti($arrUids, array('_id', 'email', 'nick', 'avatar'), true);
    	
    	return $arrUserList;
    }
    /**
     * 关注圈子数
     * @param int $id
     * @return int
     */
    public function subscribedCircleCount($id)
    {
        $cache = Cache::instance('web');
        $key = 'sub.circle.count:'.$id;
        $value = $cache->get($key);
        if (is_null($value)) {
            $modelDataCircleUser = new Model_Data_CircleUser();
            $value = $modelDataCircleUser->subscribedCircleCount($id);
            $cache->set($key, $value, 3600);
            $modelDataUserStatAll = new Model_Data_UserStatAll();
            $modelDataUserStatAll->update(array('_id' => $id), array(
            	'subscribed_circle_count' => (int) $value
            ), array('upsert' => TRUE));
        }
        return (int) $value;
    }
    /**
     * 
     * 生成邮箱验证码，并记入缓存,15分钟有效期
     * @param string $email
     * @throws Model_Logic_Exception -2010 邮箱不存在
     * 
     * @return string
     */
    public function createEmailVerifyCode($email) {
    	$arrUserInfo = $this->objModelUser->getByEmail($email);
    	if ( !$arrUserInfo ) {
    		throw new Model_Logic_Exception("email not exits", -2010, NULL);
    	}
    	$strCode =  base64_encode(md5($email."_".microtime(true)));
    	$redis = Database::instance("web_redis_master");
        $objDb = $redis->getRedisDB(1);
    	$res = $objDb->set("user:".$email, $strCode, 15*60);
    	if($res) {
    		return $strCode;
    	}
    	return false;
    }
    /**
     * 
     * 获取帐号对应的邮箱激活码
     * @param string $email
     * 
     * @return string
     */
    public function getEmailVerifyCode($email) {
    	$redis = Database::instance("web_redis_master");
        $objDb = $redis->getRedisDB(1);
    	return $objDb->get("user:".$email);
    }
    /**
     * 
     * 返回缩略图
     * @param string $sourceImage 原始图
     * 
     * @return array(
     * 	200 => 200*200的缩略图
     *  160 => 160*160的缩略图
     *  48 => 48*48的缩略图
     *  30 => 30*30的缩略图
     * )
     */
    public function resizeAvatar($sourceImage) {
    	$thumb200TmpName = "/tmp/".uniqid("200").".jpg";
    	$thumb160TmpName = "/tmp/".uniqid("160").".jpg";
    	$thumb48TmpName = "/tmp/".uniqid("48").".jpg";
    	$thumb30TmpName = "/tmp/".uniqid("30").".jpg";
		$objImage = Image::factory($sourceImage);
		$objImage->resize(200, 200);
		$objImage->save($thumb200TmpName, 85);
		$objImage->resize(160, 160);
		$objImage->save($thumb160TmpName, 85);
		$objImage->resize(48, 48);
		$objImage->save($thumb48TmpName, 92);
		$objImage->resize(30, 30);
		$objImage->save($thumb30TmpName, 92);
		return array(
			200 => $thumb200TmpName,
			160 => $thumb160TmpName,
			48  => $thumb48TmpName,
			30  => $thumb30TmpName,
		);
    }
    /**
     * 
     * 获取用户相关视频
     * @param int $uid
     * @param string $type
     * @param int $offset
     * @param int $length
     * @throws Model_Logic_Exception
     * @return array
     */
    public function getUserVideos($uid, $type, $offset=0, $length=10) {
    	$arrReturn = array(
    		'count' => 0,
    		'data' => array()
    	);
    	$objModelUserVideo = new Model_Data_UserVideo($uid);
    	
		if($type===NULL) {
			$type = Model_Data_UserVideo::TYPE_COMMENTED;
		}
		switch ($type) {
			case Model_Data_UserVideo::TYPE_SHARED:
			case Model_Data_UserVideo::TYPE_MOODED:
			case Model_Data_UserVideo::TYPE_WATCHED:
			case Model_Data_UserVideo::TYPE_WATCHLATER:
				$arrData = $objModelUserVideo->getListByType($type, $offset, ($offset+$length-1), true, true);
				break;
			case Model_Data_UserVideo::TYPE_COMMENTED:
				$arrData = $objModelUserVideo->getCommented($offset, $offset+$length, true);
				break;
			default:
				throw new Model_Logic_Exception("type({$type}) not exists", -9001);
		}
		$arrReturn['count'] = $arrData['count'];
		if($arrData['data']) {
			if($type==Model_Data_UserVideo::TYPE_COMMENTED) {
				$arrVids = Arr::pluck($arrData['data'], "video_id");
	    		$arrVideoList = $this->buildVideoAndStatAndCircle($arrVids);
	    		foreach($arrData['data'] as $row) {
	    			if( isset($arrVideoList[$row['video_id']]) ) {
	    				$row = array_merge($row, $arrVideoList[$row['video_id']]);
	    			}
	    			$arrReturn['data'][] = $row;
	    		}
			} else {
				$arrReturn['data'] = array_values( $this->buildVideoAndStatAndCircle( array_keys($arrData['data']) ) );
    			$this->mergeUserVideoRec( $arrReturn['data'], $arrData['data']);
			}
			foreach($arrReturn['data'] as $k=>$row) {
				$row['rec_type'] = 0;
				shuffle($row['circle_list']);
				$row['circle'] = $row['circle_list'] ? $row['circle_list'][0] : NULL;
				unset($row['circle_list']);
				$row['comments'] = NULL;
				$arrReturn['data'][$k] = $row;
			}
		}
		
		return $arrReturn;
    }
    /**
     * 
     * 邀请好友关注圈子
     * @param unknown_type $uid
     * @param unknown_type $intCircleId
     * @param unknown_type $content
     * @param unknown_type $arrMailList
     */
    public function inviteFriendSubscribeCircle($uid, $intCircleId, $content, $arrMailList) {
    	#TODO 发邮件
    	$userInfo = $this->objModelUser->get($uid);
    	$objLogicCircle = new Model_Logic_Circle();
    	$circleInfo = $objLogicCircle->get(intval($intCircleId));
		$failed = array();
		$objEmail = Email::factory("你的好友{$userInfo['nick']}邀请你加入圈子{$circleInfo['title']}", $content);
		$objEmail->to($arrMailList);
		$arrEmailConfig = Jkit::config("email.options");
		$objEmail->from($arrEmailConfig['from']);
		$objEmail->send($failed);
		if($failed) {
			JKit::$log->info(__FUNCTION__." uid-{$uid}, failure-", $failed);
		}
		#加入圈子feed
		$objLogicFeed = new Model_Logic_Feed();
		$objLogicFeed->addCircleFeed(intval($intCircleId), Model_Data_CircleFeed::TYPE_INVITED, $uid);
		
		#TODO 授予用户邀请勋章
		if(!$userInfo['medal'] || !in_array(Model_Data_User::MEDAL_INVITE_FRIEND, $userInfo['medal'])) {
			$arrMedal = $userInfo['medal']? $userInfo['medal']:array();
			$arrMedal[] = Model_Data_User::MEDAL_INVITE_FRIEND;
			$this->modifyUser($uid, array('medal'=>$arrMedal));
		}
		
		return true;
    }
    /**
     * 
     * 生成邀请链接
     * @param int $uid
     * @param string $type 圈子邀请，circle
     * @param array $arrExtra 附加参数
     */
    public static function buildInviteUrl($uid, $type, $arrExtra=array()) {
    	$code = "";
    	switch($type) {
    		case 'circle':
    			$code = $uid."\3"."circle\3".$arrExtra["circle_id"];
    			break;
    		default:
    			$code = $uid."\3"."{$type}";
    			if($arrExtra) {
    				$code.= implode("\3", $arrExtra);
    			}
    	}
    	return 'http://'.DOMAIN_SITE."/index/invitecb?code=".base64_encode( $code );
    }
    
    public function logFeedbackCount() {
    	$redis = Database::instance('web_redis_master');
    	$objModelReids = $redis->getRedisDB(4);
    	$strKey = "FEEDBACK_CLICK_COUNT";
    	$objModelReids->incr($strKey);
    }
}