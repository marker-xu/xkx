<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 商家信息接口
 * @author xucongbin
 */
class Model_Logic_Shop extends Model {
	
	private $objModelShop;
	
	public function __construct() {
	    $this->objModelShop = new Model_Data_Shop();
	}
	
	
	public function addShopInfo() {
	    
	}
	
	public function getShopInfo( $intShopId ) {
	    $arrShopInfo = $this->objModelShop->getInfo($intShopId);
	    return $arrShopInfo;
	}
	
	public function saveEnvPhoto( $strOrgPhoto, $intShopId ) {
	    $objModelShopenv = new Model_Data_Shopenv( );
	    $objModelShopenv->initEnvStoreDir( $intShopId );
	    $strPath = $objModelShopenv->getEnvStoreDir($intShopId);
	    $thumbOrgTmpName = $strPath."/".md5("org".microtime(true)).".jpg";
	    $thumb165TmpName = $strPath."/".md5("165".microtime(true)).".jpg";
	    $thumb82TmpName = $strPath."/".md5("82".microtime(true)).".jpg";
	    $objImage = Image::factory($strOrgPhoto);
	    $objImage->resize(165, 115);
	    $objImage->save($thumb165TmpName, 85);
	    $objImage->resize(82, 82);
	    $objImage->save($thumb82TmpName, 82);
	    move_uploaded_file($strOrgPhoto, $thumbOrgTmpName);
	    var_dump( file_exists($thumbOrgTmpName) );
	    var_dump( file_exists($thumb165TmpName) );
	    var_dump( file_exists($thumb82TmpName) );
	    $arrParams = array(
	            "logo_org" => "http://".DOMAIN_SITE."/shop_env/{$intShopId}/".basename($thumbOrgTmpName),
	            "thumb" => array(
	                    165 => "http://".DOMAIN_SITE."/shop_env/{$intShopId}/".basename($thumb165TmpName),
	                    82 => "http://".DOMAIN_SITE."/shop_env/{$intShopId}/".basename($thumb82TmpName),
	             )
	    );
	    
	    return $objModelShopenv->addShopEnv($intShopId, $arrParams);
	}
	/**
	 * 获取商品环境图片列表
	 * @param unknown $intShopId
	 * @param number $intOffset
	 * @param number $intCount
	 * @return multitype:
	 */
	public function getEnvPhotoList( $intShopId, $intOffset=0, $intCount=12 ) {
	    $arrReturn = array(
	            "total" => 0,
	            "list" => array()
	    );
	    $objModelShopenv = new Model_Data_Shopenv( );
	    $query = array(
	            "shop_id" => intval( $intShopId )
	    );
	    $fields = array(
	            "logo_org",
	            "thumb",
	            "shop_id",
	            "_id"
	    );
	    $sort = array(
	            "_id" => -1
	    );
	    $arrReturn["total"] = $objModelShopenv->count($query);
	    if( $arrReturn["total"] ) {
	        $res = $objModelShopenv->find($query, $fields, $sort, $intCount, $intOffset);
	        if( $res ) {
	            $arrReturn["list"] = $res;
	        }
	    }
	    return $arrReturn;
	}
	
	public function setShopLogo($intShopId, $intImgId, $intUserId) {
	    $objModelShopenv = new Model_Data_Shopenv( );
	    $arrShopEnv = $objModelShopenv->findOne( array("_id"=>$intImgId) );
	    if(!$arrShopEnv) {
	        return;
	    }
	    return $this->objModelShop->updateShopInfo($intShopId, array(
	            "s_image" => $arrShopEnv["thumb"]["82"],
	            "i_boss_uid" => $intUserId
	    ));
	}
}