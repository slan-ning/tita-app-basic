<?php 
class CApplication{
	private $control;
	private $action;
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
		
		$control=strtolower(isset($_GET['c'])?$_GET['c']:'index');
        $control=ucfirst($control)."Controller";
		$action=strtolower(isset($_GET['a'])?$_GET['a']:'index');

        $ctrl=new $control($control,$action);
        if($ctrl->beforeAction()) {
            $ctrl->$action();
        }

	}
	
	public function registerAutoLoad() {
		spl_autoload_register(array($this,"modelLoader"));
        spl_autoload_register(array($this,"classLoader"));
        spl_autoload_register(array($this,"controllerLoader"));
	}

    public function controllerLoader($class)
    {
        $file=APP_PATH.'/controller/'.$class.'.php';
        if(is_file($file)) {
            include $file;
        }
    }

	//加载model下的类，$class=命名空间+类名
	public function modelLoader($class) {
		$class=str_replace('\\', '/', $class);
        $file=APP_PATH.'/model/'.$class.'.php';
        if(is_file($file)) {
            include $file;
        }
	}
	
	
    public function classLoader($class) {
        $file=APP_PATH.'/class/'.$class.'.php';
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

            $dir=APP_PATH."/core/lib/";
            foreach (glob($dir."*.php") as $file) {
                include $file;
            }

            define("TITA_FRAMEWORK_HAS_LOAD_GLOBALDIR",true);
        }
    }
	
}

	