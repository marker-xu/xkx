<?php 
set_time_limit(1000);
require dirname(__FILE__)."/bootstrap.php";

//获取未完成的word列表

$objModelEstdata = new Model_Data_Postlist( );
$objLogicMmshow = new Model_Logic_Mmshow();
$objModelImgdata = new Model_Data_Imgdata();

$intCount = 0;
$t = microtime(true);
$query = array(
	'spot_pic' => array(
		'$ne' => ""
	)
);
$sort = array(
	"date" => -1
);
$fields = array(
	"post_id", "from", "spot_pic"
);
$arrPostlist = $objModelEstdata->find($query, $fields, $sort);
$strFile = "";
$strMime = "image/jpg";
$strImgContent = "";
$arrUpdateQuery = array(
	"file" => "",
	"from" => ""
);
foreach ($arrPostlist as $row) {
	if(!$row['spot_pic']) {
		continue;
	}
	$strFile = $row['post_id']."-spotimg";
	$arrImgdata = $objModelImgdata->getByFile($strFile, $row['from']);
	if(!$arrImgdata) {
		$sourceImage = $row['spot_pic'];
		if($row['from']=="sjtu") {
			$sourceImage = "http://".DOMAIN_SITE."/sjtu/piccontent?f=".$row['spot_pic'];
		}
		try {
			$arrReturn = $objLogicMmshow->resizeAvatar($sourceImage);	
		} catch (Model_Logic_Exception $e) {
			echo "EMPTY: ".$e->getCode()."||".$row['post_id']. "--". $row['from']."\n";
			continue;
		}
		echo $row['post_id']. "--". $row['from']."\n";
		$strMime = mime_content_type($arrReturn[200]);
		$strImgContent = file_get_contents($arrReturn[200]);
		$objModelImgdata->addData($strFile, array(
			"mime" => $strMime ? $strMime:"image/jpg",
			"from" => $row['from'],
			"data" => new MongoBinData($strImgContent)
		));
		@unlink($arrReturn[200]);
		$intCount++;
	} 
}

$intUsageTime = microtime(true) - $t;

$strBody = "Complete: {$intCount}, Timeusage: {$intUsageTime}ms";
die($strBody);
