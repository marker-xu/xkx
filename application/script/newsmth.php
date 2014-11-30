<?php 
set_time_limit(1000);
require dirname(__FILE__)."/bootstrap.php";

//获取未完成的word列表

$objModelEstdata = new Model_Data_Postlist( );
$objModelPostInfo = new Model_Data_Postinfo( );
$objLogicNewsmth = new Model_Logic_Newsmth();
$strStartDate = getStartDate();
$strEndDate = date("Y-m-d H:i:s");
echo "start: ".$strStartDate ." - end: ".$strEndDate."\n";
//reSnatch($strStartDate, $strEndDate);
//exit;
$intCount = 0;
$t = microtime(true);
$isSingle = false;
//mb
$arrResult = $objLogicNewsmth->fetchContentByDate( $strStartDate, $strEndDate );
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
		"post_count" => $arrParams['post_count'],
		"star" => $arrParams['star'],
		"attach" => $arrParams['attach'],
		"from" => $arrParams['from']
	);
	if( !$objModelEstdata->getByPostId($arrParams["post_id"], $arrParams['from'])) {
		//insert post_list
		$res = $objModelEstdata->addData($arrParams["post_id"], $arrListRow);
		//insert post_info
		$res = $objModelPostInfo->addData($arrParams["post_id"], $arrParams);
	} 

}

function getStartDate() {
	global $objModelEstdata;
	$strDate = date("Y-m-d H:i:s", strtotime("-1 day"));
	$query = array(
		"from" => "newsmth"
	);
	$arrList = $objModelEstdata->find($query, array("date"), array("date"=>-1), 1, 0);
	if(!$arrList) {
		return $strDate;
	}
	$arrTmp = array_pop($arrList);
	$strDate = date("Y-m-d H:i:s", strtotime($arrTmp['date'])+1);
	return $strDate;
}

function reSnatch( $strStartDate, $strEndDate ) {
	global $objModelPostInfo;
	
	$objModelNewsmth = new Model_Data_Newsmth();
	$query = array(
		"from" => "newsmth",
		"content" => "",
	);
	$arrPostinfoList = $objModelPostInfo->find($query, array("date", "post_id", "content"), array("date"=>-1));
	foreach($arrPostinfoList as $row) {
		$arrInfo = $objModelNewsmth->fetchInfo($row["post_id"]);
		if($arrInfo["content"]) {
			echo $row["post_id"]."\n";
//			print_r($arrInfo);
			$res = $objModelPostInfo->modifyByPostId($row["post_id"], $arrInfo, "newsmth");
		}
	}
}
