<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Shop extends Controller {
    
    private $objModelShop;
    
    private $objLogicShop;
    
    public function before() {
        parent::before();
        $this->_needLogin();
        $this->objModelShop = new Model_Data_Shop();
        $this->objLogicShop = new Model_Logic_Shop();
        $strAction = $this->request->action();
        $this->template->set("current_action", $strAction );
        
        $arrNeedShopAction = array(
                "environment" => 1,
                "env_add" => 1
        );
        if(!$this->_user["admin_shop_id"] && $strAction && isset( $arrNeedShopAction[$strAction] ) ) {
            $this->request->redirect(URL::site("admin/shop"));
        } else {
            $this->template->set("current_shop_info", $this->objLogicShop->getShopInfo($this->_user["admin_shop_id"]) );
        }
    }

	public function action_index()
	{
		//$this->request->forward('guide');
		$arrRules = $this->_formRule(array('@shop_name', '@shop_address'));	
		$intShopId = $this->_user["admin_shop_id"];
		if($this->request->method()!='POST') {
			$objCommon = new Model_Data_Common();
			$arrShopInfo = array();
			if($intShopId) {
				$arrShopInfo = $this->objModelShop->getInfo($intShopId);
			}
            $isEdit = $this->request->query("edit")!==NULL || !$arrShopInfo;
			$this->template->set("shop_info", $arrShopInfo);
            $this->template->set("is_edit", $isEdit);
			$this->template->set("cuisine_list", $objCommon->getCuisineList());
			return;
		}
		$arrPost = $this->request->post();
		$objValidation = new Validation($arrPost, $arrRules);
		if (! $this->valid($objValidation)) {
			return;
		}
		$strShopName = trim( $arrPost["shop_name"] );
		$arrParams = array(
		        "s_addr" => $arrPost["shop_address"],
		        "j_tel_number" => is_array( $arrPost["phone"] ) ? $arrPost["phone"]: (array) $arrPost["phone"],
		        "j_tags" => array($arrPost["cuisine"]),
		        "i_boss_uid" => $this->_uid
		);
		if($intShopId) {
		    $arrParams["s_name"] = $strShopName;
		    $res = $this->objModelShop->updateShopInfo($intShopId, $arrParams);
		    if ( !$res ) {
		        $this->err(null, "商家信息保存失败！");
		    }
		} else {
		    $res = $this->objModelShop->addShopInfo($strShopName, $arrParams);
		    if ( !$res ) {
		        $this->err(null, "商家创建失败！");
		    }
		    $objLogicUser = new Model_Logic_User();
		    $objLogicUser->modifyUser($this->_uid, array(
		            "admin_shop_id" => $res["i_id"]
		    ));
		    $objLogicUser->changeSession($this->_uid);
		}
		
		$this->ok();
	}
	
	public function action_environment() {
	    $page = (int) $this->request->param('page', 1);
	     
	    $count = 12;
	    $offset = ($page-1)*$count;
	    $intShopId = $this->_user["admin_shop_id"];
	    $arrList = $this->objLogicShop->getEnvPhotoList($intShopId, $offset, $count);
	    $pagination = Pagination::factory(array(
	            'total_items' => $arrList["total"],
	            'items_per_page' => $count
	    ));
	    $this->template->set('pagination', $pagination);
	    $this->template->set('logo_list', $arrList["list"]);
	}

	public function action_env_add() {
        $intShopId = $this->_user["admin_shop_id"];
	    if($this->request->method()!='POST') {
	        $intShopId = $this->_user["admin_shop_id"];
	        $this->template->set("shop_id", $intShopId);
	        return;
	    }
	    $avatar = $_FILES['shop_photo'];
	    
	    $validAvatar = $this->validShopLogo($avatar);
	    if( !$validAvatar['ok'] ) {
	        $this->err(NULL, $validAvatar["msg"]);
	    }
	    
	    $intImgId = $this->objLogicShop->saveEnvPhoto($_FILES['shop_photo']["tmp_name"], $intShopId);
	    
	    $this->objLogicShop->setShopLogo($intShopId, $intImgId, $this->_uid);
	    $this->request->redirect(URL::site("admin/shop/environment"));
	}

	public function action_category() {
	}
	
	public function action_cat_add() {
	}

	public function action_hours() {
	}

	public function action_preferential() {
	}

	public function action_takeaway() {
	}

	protected function _formRule($arrField = null) {
	    $arrRules = array(
            '@email' => array(
                   	'datatype' => 'email',
                   	'errmsg' => '邮箱格式错误',
            ),
            '@name' => array(
                    'datatype' => 'reg',
                    'reqmsg' => '用户名',
            		'reg-pattern' => "/^[\u4e00-\u9fa5\_a-zA-Z\d\-0-9]{2,10}$/",
            ),
            '@shop_name' => array(
                    'datatype' => 'text',
                    'reqmsg' => '商户名称',
                    'maxlength' => 20
            ),
			'@shop_address' => array(
                    'datatype' => 'text',
                    'reqmsg' => '地址',
                    'maxlength' => 20
            ),
	    );

	    if ($arrField == null) {
	        $arrRes = $arrRules;
	    } else {	    
    	    $arrRes = array();
    	    foreach ($arrField as $v) {
    	        $arrRes[$v] = $arrRules[$v];
    	    }
	    }
	    
	    return $arrRes;
	}
    
	/**
	 * @param array $avatar Array (
	 [name] => Water lilies.jpg
	 [type] => image/jpeg
	 [tmp_name] => /tmp/phpeFK8jV
	 [error] => 0
	 [size] => 83794
	 )
	 */
	private function validShopLogo($avatar) {
	    $arrReturn = array(
	            'ok' => false,
	            'msg' => ''
	    );
	    if(! $avatar['tmp_name']) {
	        $arrReturn['msg'] = "图片不能为空";
	        return $arrReturn;
	    }
	
	    if($avatar['error'] !== UPLOAD_ERR_OK) {
	        $arrReturn['msg'] = "图片上传失败";
	        return $arrReturn;
	    }
	
	    $arrImgAttr = getimagesize($avatar['tmp_name']);
	    $arrValidType = array(IMAGETYPE_GIF => true, IMAGETYPE_PNG => true,
	            IMAGETYPE_JPEG => true);
	    if(! is_array($arrImgAttr) || ! isset($arrValidType[$arrImgAttr[2]])) {
	        $arrReturn['msg'] = "图片格式错误";
	        return $arrReturn;
	    }
	    $arrReturn['attr'] = $arrImgAttr;
	
	    $maxSizeLimit = 5242880;
	    if($avatar['size'] > $maxSizeLimit) {
	        $arrReturn['msg'] = "图片大小不能超过5M";
	        return $arrReturn;
	    }
	    $arrReturn['ok'] = true;
	    return $arrReturn;
	}
} // End Welcome
