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
	
	public function run()
	{
		$this->registerAutoLoad();
		$this->config= require APP_PATH . '/config.php';
		
		$control=strtolower(isset($_GET['c'])?$_GET['c']:'index');
		$action=strtolower(isset($_GET['a'])?$_GET['a']:'index');
        $this->loadGlobalData();//加载global目录下的所有php文件
		require APP_PATH."/controller/$control.class.php";
		
		$ctrl=new $control($control,$action);

        if($ctrl->beforeAction())
        {
            $ctrl->$action();
        }
	}
	
	public function registerAutoLoad()
	{
		spl_autoload_register(array($this,"modelLoader"));
		spl_autoload_register(array($this,"libLoader"));
        spl_autoload_register(array($this,"classLoader"));
	}
	
	public function modelLoader($class)
	{
		$file=APP_PATH.'/model/'.$class.'.php';
		if(is_file($file)){
			include $file;
		}
	}
	
	public function libLoader($class)
	{
        $corePath=dirname(__FILE__);
        $file=$corePath.'/lib/'.$class.'.php';

        if(is_file($file))
        {
            include $file;
        }
	}

    public function classLoader($class)
    {
        $file=APP_PATH.'/class/'.$class.'.php';
        if(is_file($file))
        {
            include $file;
        }
    }

    public function loadGlobalData(){
        $dir=APP_PATH."/global/";
        foreach (glob($dir."*.php") as $file) {
            include $file;
        }

    }
	
	
}

	