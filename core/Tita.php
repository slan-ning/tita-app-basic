<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-10-10
 * Time: 下午5:56
 * To change this template use File | Settings | File Templates.
 */

namespace core;


class Tita {

    public static function app()
    {
        return CApplication::App();
    }

    public static function baseUrl()
    {
        return substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],"/")+1);
    }

    public static function entry()
    {
        return $_SERVER['SCRIPT_NAME'];
    }



}