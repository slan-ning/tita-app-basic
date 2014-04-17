<?php
namespace core;

class CApplication
{
    public $config;
    public static $app = null;

    public function __construct()
    {
        $this->loadGlobalData(); //加载global目录下的所有php文件
        $this->config = require APP_PATH . '/config.php';

    }

    public static function app()
    {
        if (self::$app == null) {
            self::$app = new self();
        }
        return self::$app;
    }

    public function run()
    {
        $group = isset($_GET['g']) ? strtolower($_GET['g']) : '';
        if ($group == '')
            $control = 'controller\\' . strtolower(isset($_GET['c']) ? $_GET['c'] : 'index');
        else {
            $control = $group . '\controller\\' . strtolower(isset($_GET['c']) ? $_GET['c'] : 'index');
        }

        $action = strtolower(isset($_GET['a']) ? $_GET['a'] : 'index');

        $ctrl = new $control($group, $control, $action);

        if ($ctrl->beforeAction()) {
            $ctrl->$action();
        }

    }

    public function loadGlobalData()
    {

        if (!defined("TITA_FRAMEWORK_HAS_LOAD_GLOBALDIR")) {
            $dir = APP_PATH . "/global/";
            foreach (glob($dir . "*.php") as $file) {
                include $file;
            }

            define("TITA_FRAMEWORK_HAS_LOAD_GLOBALDIR", true);
        }
    }

}

	