<?php 
require_once JKit::find_file('vendor', 'upyun.class');
class Uyun {
    
    const DEFAULT_BUCKET_DIR = "shop";
    
    private static $arrConf = array(
            "host" => "imeiwei.b0.upaiyun.com",
            "bucket" => "imeiwei",
            "user" => 'scenbuffalo',
            "pass" => "upyun2013"
    );
    public static function init( $arrConf=NULL ) {
        if($arrConf) {
            self::$arrConf = array_merge(self::$arrConf, $arrConf);
        }
    }
    
    public static function getCloudObj() {
        $bucketname = self::$arrConf["bucket"];
        $username = self::$arrConf["user"];
        $password = self::$arrConf["pass"];
        $objInc = new UpYun($bucketname, $username, $password);
        
        return $objInc;
    }
    
    public static function uploadFile( $strFile, $strDestPath=NULL, $arrOpt= array() ) {
        $objInc = self::getCloudObj();
        
        $strMd5 = md5(file_get_contents($strFile));
        $strOrgName = basename($path, "jpg");
        $arrTmp = explode(".", $strOrgName);
        $strDestFile = $strDestPath."/".$strMd5.".".array_pop($arrTmp);
        try {
            $fp = fopen($strFile, "rb");
            if($arrOpt) {
                $res = $objInc->writeFile($strDestFile, $fp, true, $arrOpts);
            } else {
                $res = $objInc->writeFile($strDestFile, $fp, true);
            }
            fclose($fp);
        } catch (Exception $e) {
            fclose($fp);
            echo $e->getCode();
            echo $e->getMessage();
        }
        var_dump($res);
        
        return $res;
    }
}