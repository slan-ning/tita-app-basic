<?php
if (!defined("TITA_FRAMEWORK_HAS_REQUIRED")) {

    define('TITA_FRAMEWORK_HAS_REQUIRED', true);

    if (!defined('APP_PATH')) //定义应用路径
    {
        define('APP_PATH', dirname(dirname(__FILE__)));
    }

    if (!defined('ROOT_PATH')) //定义系统主目录，aodiansoft专用，非tita核心方法
    {
        define('ROOT_PATH', dirname(dirname(dirname(__FILE__))));
    }

    function TitaCoreClassLoader($class)//加载框架下的类，$class=命名空间+类名
    {
        $class = str_replace('\\', '/', $class);

        $file = APP_PATH . '/' . $class . '.php';

        if (is_file($file)) {
            include $file;
        }
    }

    spl_autoload_register('TitaCoreClassLoader');//注册自动加载




}

