<?php defined('SYSPATH') or die('No direct script access.');

class Model_Data_Common {
    
    private $strBaseUrl = "/enum";
    
    protected $strConfigName = "shop_api";
    
    /**
     * 菜品类型
     * @return array
     */
    public function getFoodtypeList( ) {
        $arrParams = array(
                "type" => "foodtype",
        ); 
        $mixedAction = $this->strBaseUrl. "?" . http_build_query($arrParams);
        return $this->request($mixedAction);
    }
    /**
     * 菜品推荐类型
     * @return array
     */
    public function getRecommandList( ) {
        $arrParams = array(
                "type" => "recommend",
        );
        $mixedAction = $this->strBaseUrl. "?" . http_build_query($arrParams);
        return $this->request($mixedAction);
    }
    /**
     * 饭店菜系信息
     * @param int $intId
     * @return array
     */
    public function getCuisineList( ) {
        $arrParams = array(
                "type" => "cuisine",
        );
        $mixedAction = $this->strBaseUrl. "?" . http_build_query($arrParams);
        return $this->request($mixedAction);
    }
    
    /**
     * 菜品口味信息
     * @param int $intId
     * @return array
     */
    public function getTasteList( ) {
        $arrParams = array(
                "type" => "taste",
        );
        $mixedAction = $this->strBaseUrl. "?" . http_build_query($arrParams);
        return $this->request($mixedAction);
    }
    
    public function request( $mixedAction, $arrParams=array(), $returnedAll=false ) {
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