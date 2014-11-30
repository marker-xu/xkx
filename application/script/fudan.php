<?php 
set_time_limit(1000);
require dirname(__FILE__)."/bootstrap.php";

//获取未完成的word列表

$objModelEstdata = new Model_Data_Postlist( );
$objModelPostInfo = new Model_Data_Postinfo( );
$objLogicFudan = new Model_Logic_Fudan();
$strStartDate = getStartDate();
$strEndDate = date("Y-m-d H:i:s");
$intCount = 0;
$t = microtime(true);
echo "start: ".$strStartDate ." - end: ".$strEndDate."\n";
//mb
$isSingle = false;
$arrResult = $objLogicFudan->fetchContentByDate($isSingle, $strStartDate, $strEndDate);

if($arrResult) {
	foreach($arrResult as $row) {
		$intCount++;
		writeDataIntoMongo($row);
	}
}

//single
$isSingle = true;
$strStartDate = getStartDate($isSingle);
$arrResult = $objLogicFudan->fetchContentByDate($isSingle, $strStartDate, $strEndDate);
if($arrResult) {
	foreach($arrResult as $row) {
		$intCount++;
		writeDataIntoMongo($row);
	}
}
$intUsageTime = microtime(true) - $t;

$strBody = "Complete: {$intCount}, Timeusage: {$intUsageTime}ms";
die($strBody);

function writeDataIntoMongo( $arrParams ) {
	global $objModelEstdata, $objModelPostInfo;
	
	$arrListRow = array(
		"title" => $arrParams['title'], 
		"date" => $arrParams['date'], 
		"author" => $arrParams['author'],
		"gender" => $arrParams['gender'],
		"spot_pic" => $arrParams['spot_pic'],
		"from" => $arrParams['from']
	);
	if( !$objModelEstdata->getByPostId($arrParams["post_id"], $arrParams['from'])) {
		//insert post_list
		$res = $objModelEstdata->addData($arrParams["post_id"], $arrListRow);
		//insert post_info
		$res = $objModelPostInfo->addData($arrParams["post_id"], $arrParams);
	}
}

function getStartDate( $isSingle=false ) {
	global $objModelEstdata;
	$strDate = date("Y-m-d H:i:s", strtotime("-1 day"));
	$query = array(
		"from" => $isSingle ? "fudan_single" : "fudan_mb",
	);
	$arrList = $objModelEstdata->find($query, array("date"), array("date"=>-1), 1, 0);
	if(!$arrList) {
		return $strDate;
	}
	$arrTmp = array_pop($arrList);
	$strDate = date("Y-m-d H:i:s", strtotime($arrTmp['date'])+1);
	return $strDate;
}
