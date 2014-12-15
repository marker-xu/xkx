<?php
/**
 * string util
 * @author jiangchanghua<jiangchanghua@baidu.com>
 * @since 2013-03-21
 * @package holmes.web.framework.util
 *
 */
final class StringUtil{

    /**
     * text type
     * @var int
     */
    const TEXT_TYPE_ALPHA = 1;          // 字母集合
    const TEXT_TYPE_NUMERIC = 2;        // 数字集合
    const TEXT_TYPE_ALPHANUMERIC = 3;   // 字母数字集合
    const TEXT_TYPE_DISTINCT = 4;       // 区别明显的字母数字集合

    public static $TEXT_TYPE_MAP = array(
        self::TEXT_TYPE_ALPHA => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 
        self::TEXT_TYPE_NUMERIC => '0123456789', 
        self::TEXT_TYPE_ALPHANUMERIC => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 
        self::TEXT_TYPE_DISTINCT => '2345679ACDEFHJKLMNPRSTUVWXYZ',
    );

    /**
     * generate random text
     * @param int $length
     * @param int $type
     * @return string
     */
    public static function generateRandomText($length, $type){
        if (!isset(self::$TEXT_TYPE_MAP[$type])){
            return '';
        }

        $str = '';
        $charSet = self::$TEXT_TYPE_MAP[$type];
        $size = strlen($charSet);
        for($i = 0; $i < $length; $i++){
            $rand = mt_rand(0, $size - 1);
            $str .= $charSet{$rand};
        }

        return $str;
    }

    /**
     * format time: 81 -> 00:01:21
     * @param int $seconds
     */
    public static function formatTime($seconds){
        return sprintf("%02d:%02d:%02d", $seconds / 3600, (($seconds % 3600) / 60), ($seconds % 60));
    }

    /**
     * 将下划线分隔的字符串驼峰化: this_is_a_simple_test => ThisIsASimpleTest
     * @param string $str
     */
    public static function camelize($str){
        $str = strtolower($str);
        $tokens = explode('_', $str);
        foreach ($tokens as $key => $val){
            $val = trim($val);
            if ($val === ''){
                continue;
            }
            $tokens[$key] = ucfirst($val);
        }
        return implode('', $tokens);
    }

    /**
     * mock mysql_real_escape_string
     * @param string $str
     */
    public static function mysqlEscape($str){
        $search = array("\\", "\0", "\n", "\r", "\x1a", "'", '"');
        $replace = array("\\\\", "\\0", "\\n", "\\r", '\\Z', '\\\'', '\"');
        return str_replace($search, $replace, $str);
    }

    /**
     * 将$str转化成GBK
     * @param string $str 输入字符串
     * @param string $inEncode 输入字符串的编码
     * @return string GBK的字符串
     */
    public static function toGBK($str, $inEncode = "UTF-8") {
        return iconv($inEncode, "GBK", $str);
    }

    /**
     * 将$str转化成utf8
     * @param string $str 输入字符串
     * @param string $inEncode 输入字符串的编码
     * @return string UTF8的字符串
     */
    public static function toUTF8($str, $inEncode = "GBK") {
        return iconv($inEncode, "UTF-8//IGNORE", $str);
    }

    /**
     * 判断字符串内容是否是一个整数
     * @param string $str
     * @return boolean
     */
    public static function isInteger($str){
        $valid = true;
        $pattern = '/^[+-]?\d+$/i';
        if(!preg_match($pattern, $str)){
            $valid = false;
        }
        return $valid;
    }

    /**
     * 判断字符串内容是否是一个浮点数
     * @param string $str
     * @return boolean
     */
    public static function isFloat($str){
        $valid = true;
        $pattern = '/^[+-]?\d+(.\d+)?$/i';
        if(!preg_match($pattern, $str)){
            $valid = false;
        }
        return $valid;
    }

    /**
     * 是否str以begin开头
     * @param string $str
     * @param string $begin
     * @return boolean
     */
    public static function beginWith($str, $begin){
        $pos = strpos($str, $begin);
        if ($pos === 0){
            return true;
        }
        return false;
    }

    /**
     * 是否str以end结尾
     * @param string $str
     * @param string $end
     * @return boolean
     */
    public static function endWith($str, $end){
        $pos = strrpos($str, $end);
        if ($pos !== false && $pos + strlen($end) === strlen($str)){
            return true;
        }
        return false;
    }

    /**
     * 转义
     * @param string $str
     * @return string
     */
    public static function htmlSafeStr($str){
        return htmlspecialchars($str, ENT_QUOTES, "utf-8");
    }

}
