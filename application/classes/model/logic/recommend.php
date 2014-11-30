<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 推荐、缤纷等相关页面逻辑
 * @author xucongbin
 */
class Model_Logic_Recommend {
	const CIRCLE_MAX_VIDEO_NUM = 200; //圈子详情页最多显示200个视频
    
	
	public function __construct() {
	}
	/**
	 * 
	 * 获取推荐用户选取的tag
	 */
	public function getRecommendUserTags($offset=0, $count=10) {
		$arrTags = array(
		        "猫肉","大闸蟹", "青椒"
		);
		return array_slice($arrTags, $offset, $count);
	}

}