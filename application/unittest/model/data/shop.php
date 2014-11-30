<?php defined('SYSPATH') or die('No direct script access.');

class ModelDataRecommendTest extends UnitTestCase {
	private $_model;
    
    function __construct()
    {
        parent::__construct();
        
        $this->_model = new Model_Data_Shop();
    }
    
    function setUp()
    {
    }
    
    function tearDown()
    {
    }
    
    public function test_getShopList() {
    	return;
    	$intOffset = "10";
    	$intCount = 10;
    	$arr  = $this->_model->getShopList( $intOffset, $intCount );
    	print_r($arr);
    	$this->assertIsA($arr, "array");
    }
    
    public function test_getInfo() {
        return;
    	$intId = 12;
    	$arr  = $this->_model->getInfo($intId);
    	print_r($arr);
    	$this->assertIsA($arr, "array");
    }
    
    public function test_getPromotion() {
    	return;
		$intId = "10";
    	$arr  = $this->_model->getPromotion($intId);
    	print_r($arr);
    	$this->assertIsA($arr, "array");
    }
    public function test_addShopPraise() {
    	return;

    	$intId = "10";
    	$intUid = 105;
    	$arr  = $this->_model->addShopPraise($intId, $intUid, $strUserName);
    	var_dump($arr);
    	$this->assertTrue($arr);
    }
    
    public function test_addShopFavorite() {
    	return;
    }
    
    public function test_getUserCircles() {
        return;
    	
    }
    
    public function test_addShopInfo() {
        return;
        $strShopName = "海上传奇三期";
        $arrInfo = array(
                "j_tel_number" => array(13521987647),
                "j_tags" => "请选择",
                "i_boss_uid" => 105,
                "s_addr" => "华夏中路30号"
        );
        $res = $this->_model->addShopInfo($strShopName, $arrInfo);
        var_dump($res);
        $this->assertIsA($res, "array");
        return;
    }
    
    public function test_updatesShopInfo() {
//         return;
        $strShopName = "海上传奇三期";
        $intUid = 105;
        $arrInfo = array(
                "s_image" => "http://www.aimeiwei.cc/shop_env/6/eab7932f578cd5773e95bdb6f05ee4d6.jpg",
                "i_boss_uid" => $intUid
        );
        $intId = 6;
        print_r($arrInfo);
        $res = $this->_model->updateShopInfo($intId, $arrInfo);
        var_dump($res);
        $this->assertTrue($res);
        return;
    }
}