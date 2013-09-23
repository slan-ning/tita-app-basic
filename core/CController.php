<?php 
class BaseController {
	protected $view;
	protected $control;
	protected $action;
	protected $layout="main";
    public $widgetPointer='';
	
	function __construct($control,$action){
		$this->control=$control;
		$this->action=$action;
		$this->view=new CView($this);

	}
	
	function __call( $method, $arg_array ) {
		$method="action".$method;
		if (method_exists($this,$method)) {
			$this->$method();

		}elseif ($this->action!='404') {
			header("Location: index.php?c=system&a=404");
		}
		else{
			header("HTTP/1.0 404 Not Found");
			echo 'page not found!';
		}
		
	}
	
	protected function assign($name,$value=''){
		$this->view->assign($name,$value);
	}
	
	protected function display($tpl=""){
		$tplname=($tpl=="")?$this->action:$tpl;
        $classname=strtolower(substr($this->control,0,strpos($this->control,'Controller')));
		$this->view->display($tplname,$classname,$this->layout );
	}

    protected function widgetDisplay($tpl=''){
        $tplname=($tpl=='')?$this->widgetPointer:$tpl;
        $classname=strtolower(substr($this->control,0,strpos($this->control,'Controller')));
        $this->view->display($tplname,$classname,'');
    }

	//判断变量是否提交过来
	protected function checkVarNull($ary)
	{
		foreach($ary as $val)
		{
			if(!isset($_REQUEST[$val])||$_REQUEST[$val]==""){
				break;
				return false;
			}
        }
        return true;
	}

    public function beforeAction()
    {
        return true;
    }
}