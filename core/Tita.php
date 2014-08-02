<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-10-10
 * Time: 下午5:56
 * To change this template use File | Settings | File Templates.
 */

namespace core;


class Tita
{

    private static $clientScript;

    public static function app()
    {
        return CApplication::app();
    }

    /**
     * 应用根目录
     * /admin/test.php?a=test  对应/
     * /index.php?c=admin 对应/
     * @return string
     */
    public static function baseUrl()
    {
        return substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],"/")+1);
    }

    /**
     * 当前入口路径
     * /admin/test.php?a=test  对应/admin/test.php
     * /test.php?a=test 对应/test.php
     * @return string
     */
    public static function entry()
    {
        if (strpos($_SERVER['REQUEST_URI'], '?') > 0) {
            return substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "?"));
        } else {
            return $_SERVER['REQUEST_URI'];
        }
    }

    public static function register_script($src)
    {
        self::$clientScript[] = $src;
    }

    public static function client_script()
    {
        $str = '';
        foreach (self::$clientScript as $script) {
            $str .= $script . "\n";
        }
        return $str;
    }


}