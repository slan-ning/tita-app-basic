<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 12-12-26
 * Time: 上午11:39
 * Tita 框架 入口
 */
//ini_set('display_errors','On');
//error_reporting(E_ALL);

//session_start();
header('Content-Type: text/html;charset=utf-8');
define('APP_PATH',dirname(__FILE__));//app base dir
require './vendor/autoload.php';//加载框架核心
$appConfig = require APP_PATH . '/config.php';
$app=\core\Tita::App($appConfig);
$app->run();