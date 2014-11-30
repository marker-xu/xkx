<?php defined('SYSPATH') or die('No direct script access.');

class Model_Data_Imgdata extends Model_Data_MongoCollection {
	
	
	public function __construct() {
		parent::__construct("cloudsearch", "mmshow", "img_data");
	}
		
	/**
	 * 
	 * Enter description here ...
	 * @param $query
	 * @param $arrParams
	 */
	public function addData($strFile, $arrParams) {
		JKit::$log->debug(__FUNCTION__." file-{$strFile}, params-", $arrParams);
		$arrParams['file'] = $strFile;
		if( !isset($arrParams['create_time']) ) {
			$arrParams['create_time'] = new MongoDate();
		}
		$arrParams['update_time'] = $arrParams['create_time'];
		try {
			$arrResult = $this->getCollection()->insert($arrParams, true);
		} catch (MongoCursorException $e) {
			JKit::$log->warn("add failure, code-".$e->getCode().", msg-".$e->getMessage().", param-", $arrParams);
			
			return false;
		}
		JKit::$log->debug(__FUNCTION__." result-", $arrResult);
		if($arrResult["ok"]==1) {
			return true;
		}
		
		return false;
	}
	
	public function getByFile($strFile, $strFrom=null, $fields=array() ) {
		$query = array(
			"file" => $strFile,
			"from" => $strFrom ? $strFrom:"fudan_mb"
		);
		return $this->findOne($query, $fields);
	}
}