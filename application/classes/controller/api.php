<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api extends Controller {
	
	private $objLogicMmshow;
	
	public function before() {
		parent::before();
		
		$this->objLogicMmshow = new Model_Logic_Mmshow();
	}
	
	public function action_list() {
		$arrResult = $this->objLogicMmshow->getRecommendResult(15);
		
		$this->ok($arrResult);
	}
	
	public function action_info() {
		$postId = $this->request->query("pid");
		$strFrom = $this->request->query("from");
		$arrInfo = $this->objLogicMmshow->getPostInfo($strFrom, $postId);
		$arrPatterns = array(
			"/<p[^>]*>(.*?)<\/p>/i",
			"/<br[^>]*>/i",
			"/\&nbsp;/i"
		);
		$arrReplace = array(
			"\n$1\n",
			"\n",
			" "
		);
//		$arrInfo['content'] = preg_replace("/<p[^>]*>(.*?)<\/p>/i", "\n$1\n", $arrInfo['content']);
//		$arrInfo['content'] = strip_tags(preg_replace("/<br[^>]*>/i", "\n", $arrInfo['content']));
		
		$arrInfo['content'] = strip_tags( preg_replace($arrPatterns, $arrReplace, $arrInfo['content']), "<img>" );
		print_r( $arrInfo['content'] );
		$arrInfo['content'] = $this->rebuildContent($arrInfo['content'], $arrInfo['pic_list'], $strFrom);
//		print_r($arrInfo);
		$this->ok($arrInfo);
	}
	
	public function action_spotimg() {
		$postId = $this->request->query("pid");
		$strFrom = $this->request->query("from");
		$arrInfo = $this->objLogicMmshow->getPostInfo($strFrom, $postId);
//		print_r($arrInfo);
		if( !$arrInfo || !$arrInfo['spot_pic'] ) {
			$this->err();
		}
		$objModelImgdata = new Model_Data_Imgdata();
		
		$sourceImage = $arrInfo['spot_pic'];
		$strFile = $postId."-spotimg";
		$strMime = "image/jpg";
		$strImgContent = "";
		$arrImgdata = $objModelImgdata->getByFile($strFile, $strFrom);
		if(!$arrImgdata) {
			$arrImgdata = array();
			if($arrInfo['from']=="sjtu") {
				$sourceImage = "http://".DOMAIN_SITE."/sjtu/piccontent?f=".$arrInfo['spot_pic'];
			}
			$arrReturn = $this->objLogicMmshow->resizeAvatar($sourceImage);
			$strMime = mime_content_type($arrReturn[200]);
			$strImgContent = file_get_contents($arrReturn[200]);
			$objModelImgdata->addData($strFile, array(
				"mime" => $strMime ? $strMime:"image/jpg",
				"from" => $strFrom,
				"data" => new MongoBinData($strImgContent)
			));
			@unlink($arrReturn[200]);
		} else {
			$strMime = $arrImgdata['mime'];
			$strImgContent = $arrImgdata['data']->bin;
		}
		
		$this->response->headers('Content-Type', $strMime);
		$expire = 360*86400;
		$this->response->headers('Cache-Control', "max-age=$expire, public");
    	$this->response->headers('Expires', gmdate('D, d M Y H:i:s', time() + $expire) . ' GMT');
		$this->response->body( $strImgContent );
	}
	
	private function rebuildContent($strContent, $arrPicList, $strFrom) {
		$arrReturn = array(
			
		);
		if(!$arrPicList) {
			$arrReturn[] = array(
				"data" => $strContent,
				"type" => "text"
			);
			
			return $arrReturn;
		}
		$strPattern = "/<img[^>]+>/i";
		$arrContent = preg_split($strPattern, $strContent);
		$strImgPrefix = "";
		if($strFrom=="sjtu") {
			$strImgPrefix = "http://".DOMAIN_SITE."/sjtu/piccontent?f=";
		}
		foreach ( $arrContent as $k=>$strTmp ) {
			if($k) {
				$arrReturn[] = array(
					"data" => $strImgPrefix.$arrPicList[$k-1] ,
					"type" => "img"
				);
			}
			$arrReturn[] = array(
				"data" => $strTmp,
				"type" => "text"
			);
			
		}
		foreach($arrReturn as $k=>$row) {
			if($k && $arrReturn[$k-1]['type']=="img" 
				&& $row['data']=="\n") {
				unset( $arrReturn[$k] );		
			}
		}
		$intLength = count($arrPicList);
		for($i=$k; $i<$intLength; $i++) {
			$arrReturn[] = array(
				"data" => $strImgPrefix.$arrPicList[$k-1] ,
				"type" => "img"
			);
		}
		
		return array_values($arrReturn);
	}
	
}