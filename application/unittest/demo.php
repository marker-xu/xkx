<?php defined('SYSPATH') or die('No direct script access.');

class DemoTest extends UnitTestCase
{
    function __construct()
    {
        parent::__construct();
    }
    
    function setUp() {}
    
    function tearDown() {}

    function test_test()
    {
        $str = '剧情简介：山姆·维特维奇（希亚·拉博夫 饰）成功阻止了“霸天虎”和“汽车人”两派变形金刚的对决，拯救了全世界的两年后，他虽然被视为英雄人物，但是他还是一个青少...';
        print_r(mb_strwidth($str));
        print_r(mb_strimwidth($str, 0, 4, '', "UTF-8"));
        print_r(mb_internal_encoding());
    }
    
    function test_image() {
        $sourceImage = DOCROOT."resource/images/366.png";
        $thumb200TmpName = "/tmp/imeiwei/".uniqid("100").".jpg";
        $thumb160TmpName = "/tmp/imeiwei/".uniqid("64").".jpg";
        $thumb48TmpName = "/tmp/imeiwei/".uniqid("32").".jpg";
        $thumb30TmpName = "/tmp/imeiwei/".uniqid("16").".jpg";
        $objImage = Image::factory($sourceImage);
        $objImage->resize(100, 100);
        $objImage->save($thumb200TmpName, 85);
        $objImage->resize(64, 64);
        $objImage->save($thumb160TmpName, 85);
        $objImage->resize(32, 32);
        $objImage->save($thumb48TmpName, 92);
        $objImage->resize(16, 16);
        $objImage->save($thumb30TmpName, 92);
        return array(
                100 => $thumb200TmpName,
                64 => $thumb160TmpName,
                32  => $thumb48TmpName,
                16  => $thumb30TmpName,
        );
    }
}
