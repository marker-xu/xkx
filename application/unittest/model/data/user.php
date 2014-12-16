<?php 
require(dirname(__FILE__)."/../../bootstrap.php");

class ModelDataUserTest extends PHPUnit_Framework_TestCase {
	private $_model;
    
    function __construct()
    {
        parent::__construct();
        
        $this->_model = new Model_Data_User();
    }
    
    function setUp()
    {
    }
    
    function tearDown()
    {
    }
    
    public function test_getId() {
    	return;
    	$id = "1";
    	$tmp  = $this->_model->get( $id );
    	print_r( $tmp );
    	$res = $tmp instanceof UserItem;
    	$this->assertTrue($res);
    }
    
    public function test_getInfo() {
        return;
    	$nick = "baowei";
    	$tmp  = $this->_model->getByNick($nick);
    	print_r( $tmp );
    	$res = $tmp instanceof UserItem;
    	$this->assertTrue($res);
    }
    
    public function test_addUser() {
//         return;
        $email = "";
        $arrParams = array(
                "nick" => "sea-saga",
                "is_email_verified" => UserItem::EmailVerifiedYes
        );
        $nick = "baowei";
        $res  = $this->_model->addUser($email, $arrParams);
        $this->assertTrue((boolean)$res);
    }
    
    public function test_modifyById() {
        return;
        $nick = "baowei";
        $tmp  = $this->_model->getByNick($nick);
        print_r( $tmp );
        $res = $tmp instanceof UserItem;
        $this->assertTrue($res);
    }
    
}