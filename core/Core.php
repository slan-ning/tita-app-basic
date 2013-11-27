<?php
if(!defined("TITA_FRAMEWORK_HAS_REQUIRED"))
{
    $path=dirname(__FILE__);
    require $path."/CApplication.php";
    require $path."/CController.php";
    require $path."/CView.php";
    require $path."/Tita.php";

    define('TITA_FRAMEWORK_HAS_REQUIRED',true);
}

