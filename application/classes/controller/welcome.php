<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
		//$this->request->forward('guide');
		$loginUrl = URL::site("connect/index?type=".Model_Data_UserConnect::TYPE_QQ, null, false);
		$this->template->set("login_url", $loginUrl);
	}
	
	public function action_sample()
	{
		$obj = new Model_Data_Common();
		print_r($obj->getCuisineList());
		$this->template->set('person', 'akira');
		//$this->response->body(__TEMPLATE__);
	}
	
	public function action_list() {
		$objLogicMmshow = new Model_Logic_Mmshow();
		$arrDateBetween = array(
			"start" =>date("Y-m-d", strtotime("-1 day"))." 00:00:00",
			"end" =>date("Y-m-d H:i:s"),
		);
		$intOffset = 0; 
		$intCount = 20;
		$arrList = $objLogicMmshow->getPostList($arrDateBetween, $intOffset, $intCount);
		$this->template->set("show_list", $arrList);
	}
	
	public function action_viewinfo() {
		$postId = $this->request->query("pid");
		$strFrom = $this->request->query("from");
		$objLogicMmshow = new Model_Logic_Mmshow();
		$arrInfo = $objLogicMmshow->getPostInfo($strFrom, $postId);
		$this->template->set("post_info", $arrInfo);
	}

} // End Welcome
