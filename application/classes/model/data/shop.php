<?php defined('SYSPATH') or die('No direct script access.');

class Model_Data_Shop {
    
    private $strBaseUrl = "/shop";
    
    protected $strConfigName = "shop_api";
    
    /**
     * 店铺列表
     * @param int $intOffset
     * @param int $intCount
     * @return array
     */
    public function getShopList( $intOffset=0, $intCount=10 ) {
        $arrParams = array(
                "type" => "list",
                "pageno" => floor($intOffset/$intCount)
        ); 
        $mixedAction = $this->strBaseUrl. "?" . http_build_query($arrParams);
        return $this->request($mixedAction);
    }
    /**
     * 店铺详情
     * @param int $intId
     * @return array
     */
    public function getInfo( $intId ) {
        $arrParams = array(
                "type" => "info",
                "i_id" => $intId
        );
        $mixedAction = $this->strBaseUrl. "?" . http_build_query($arrParams);
        return $this->request($mixedAction);
    }
    /**
     * 店铺促销信息
     * @param int $intId
     * @return array
     */
    public function getPromotion( $intId ) {
        $arrParams = array(
                "type" => "promotion",
                "i_id" => $intId
        );
        $mixedAction = $this->strBaseUrl. "?" . http_build_query($arrParams);
        return $this->request($mixedAction);
    }
    
    /**
     * 赞扬店铺接口
     * @param int $intId
     * @return array
     */
    public function addShopPraise( $intId, $intUid=NULL, $strUserName=NULL ) {
        $arrParams = array(
                "type" => "insert",
                "i_id" => $intId,
        );
        if( $intUid ) {
            $arrParams["i_uid"] = $intUid;
        }
        if( $strUserName ) {
            $arrParams["s_uname"] = $strUserName;
        }
        $arrTmp = $this->request($this->strBaseUrl, array("post_vars" => $arrParams), true, true );
        
        return isset($arrTmp["retcode"]) && $arrTmp["retcode"]===0;
    }
    /**
     * 用户收藏店铺
     * @param int $intUid
     * @param int $intShopId
     * @return Ambigous <boolean, multitype:, mixed>
     */
    public function addShopFavorite(  $intUid, $intShopId ) {
        $arrParams = array(
                "type" => "favo",
                "i_shop_id" => $intShopId,
                "i_user_id" => $intUid,
                "op" => "favo"
        );
        $arrTmp = $this->request($this->strBaseUrl, array("post_vars" => $arrParams), true, true );
        
        return isset($arrTmp["retcode"]) && $arrTmp["retcode"]===0;
    }
    /**
     * 
     * @param unknown $intUid
     * @param unknown $intShopId
     * @return Ambigous <boolean, multitype:, mixed>
     */
    public function removeShopFavorite(  $intUid, $intShopId ) {
        $arrParams = array(
                "type" => "favo",
                "i_shop_id" => $intShopId,
                "i_user_id" => $intUid,
                "op" => "unfavo"
        );
        $arrTmp = $this->request($this->strBaseUrl, array("post_vars" => $arrParams), true, true );
        
        return isset($arrTmp["retcode"]) && $arrTmp["retcode"]===0;
    }
    
    public function addShopInfo( $strShopName, $arrInfo ) {
        $arrParams = $arrInfo;
        $arrParams["type"] = "insert";
        $arrParams["s_name"] = $strShopName;
        $arrDefault = array(
                "j_detail" => new stdClass(),
                "j_tel_number" => array(),
                "j_promotion" => new stdClass(),
                "i_take_out" => 0,
                "j_tags" => array(),
                "s_addr" => "",
                "s_image" => ""
        );
        $arrParams +=  $arrDefault;
		$arrParams["j_detail"] = json_encode($arrParams["j_detail"]);
		$arrParams["j_tel_number"] = json_encode($arrParams["j_tel_number"]);
		$arrParams["j_tags"] = json_encode($arrParams["j_tags"]);
		$arrParams["j_promotion"] = json_encode($arrParams["j_promotion"]);
        $arrTmp = $this->request($this->strBaseUrl, array("post_vars" => $arrParams) , false, true);
        
        return $arrTmp;
    }
    /**
     * 更新商铺信息
     * @param unknown $intId
     * @param unknown $arrInfo
     * @return boolean
     */
    public function updateShopInfo( $intId, $arrInfo ) {
        $arrParams = $arrInfo;
        $arrParams["type"] = "update";
        $arrParams["i_id"] = $intId;
		if(isset($arrParams["j_detail"])) {
			$arrParams["j_detail"] = json_encode($arrParams["j_detail"]);
		}
		if(isset($arrParams["j_tel_number"])) {
			$arrParams["j_tel_number"] = json_encode($arrParams["j_tel_number"]);
		}
		if(isset($arrParams["j_tags"])) {
			$arrParams["j_tags"] = json_encode($arrParams["j_tags"]);
		}
		if(isset($arrParams["j_promotion"])) {
			$arrParams["j_promotion"] = json_encode($arrParams["j_promotion"]);
		}
        $arrTmp = $this->request($this->strBaseUrl, array("post_vars" => $arrParams), true, true );
    
        return isset($arrTmp["retcode"]) && $arrTmp["retcode"]===0;
    }
    
    public function request( $mixedAction, $arrParams=array(), $returnedAll=false, $isPost=false ) {
	if($isPost) {
	   $arrParams["method"] = "post";
	}
        $strContent = Rpc::call($this->strConfigName, $mixedAction, $arrParams );
        
        if( !$strContent || !($arrResult = json_decode( $strContent, true ) ) ) {
            JKit::$log->warn( "the backend failure, action-".$mixedAction.", ret-".$strContent.", params-", $arrParams );
            return false;
        }
        if( $returnedAll ) {
            return $arrResult;
        }
        if( $arrResult["retcode"]!==0 ) {
            JKit::$log->warn( "the backend response failure, code-{$arrResult["retcode"]}, msg-{$arrResult["message"]}, action-" . 
            $mixedAction . ", params-", $arrParams );
            return array();
        }
        return $arrResult["retbody"];
    }
    
    
}
