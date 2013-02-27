<?php 
class BaseController {
	protected $view;
	protected $control;
	protected $action;
	protected $layout="main";
	
	function __construct($control,$action){
		$this->control=$control;
		$this->action=$action;
		$this->view=new CView();

	}
	
	function __call( $method, $arg_array ) {
		$method="action".$method;
		$this->$method();
	}
	
	protected function assign($name,$value=''){
		$this->view->assign($name,$value);
	}
	
	protected function display($tpl=""){
		$tplname=($tpl=="")?$this->action:$tpl;
		
		$this->view->display($tplname,$this->control,$this->layout );
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
