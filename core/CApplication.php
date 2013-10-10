<?php
namespace core;

class CApplication{
	public $config;
	public static $app=null;
	
	public static function App(){
		if(self::$app==null){
			self::$app=new self();
		}
		return self::$app;
	}
	
	public function run() {
        $this->loadGlobalData();//加载global目录下的所有php文件
		$this->registerAutoLoad();
		$this->config= require APP_PATH . '/config.php';

        $group=isset($_GET['g'])?strtolower($_GET['g']):'';
		if($group=='')
            $control='controller\\'.strtolower(isset($_GET['c'])?$_GET['c']:'index');
        else
            $control=$group.'\controller\\'.strtolower(isset($_GET['c'])?$_GET['c']:'index');


		$action=strtolower(isset($_GET['a'])?$_GET['a']:'index');



        $ctrl=new $control($group,$control,$action);



        if($ctrl->beforeAction())
        {
            $ctrl->$action();
        }


        

	}
	
	public function registerAutoLoad() {
        spl_autoload_register(array($this,"classLoader"));
	}

	//加载框架下的类，$class=命名空间+类名
	public function classLoader($class) {
		$class=str_replace('\\', '/', $class);

        $file=APP_PATH.'/'.$class.'.php';

        if(is_file($file)) {
            include $file;
        }
	}
	


    public function loadGlobalData(){

        if(!defined("TITA_FRAMEWORK_HAS_LOAD_GLOBALDIR"))
        {
            $dir=APP_PATH."/global/";
            foreach (glob($dir."*.php") as $file) {
                include $file;
            }

            define("TITA_FRAMEWORK_HAS_LOAD_GLOBALDIR",true);
        }
    }
	
}

	