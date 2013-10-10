<?php
namespace core;

class CController {
	protected $view_;
    protected $group_;
	protected $control_;
	protected $action_;
	protected $layout="main";
    public $widgetPointer='';
	
	function __construct($group,$control,$action){
		$this->control_=$control;
		$this->action_=$action;
		$this->view_=new CView($this);
        $this->group_=$group;

	}
	
	function __call( $method, $arg_array ) {
		$method="action".$method;
		if (method_exists($this,$method)) {
			$this->$method();

		}
		else{
			header("HTTP/1.0 404 Not Found");
			echo 'page not found!';
		}
		
	}
	
	protected function assign($name,$value=''){
		$this->view_->assign($name,$value);
	}
	
	protected function display($tpl=""){
		$tplname=($tpl=="")?$this->action_:$tpl;
        $classname=substr($this->control_,strrpos($this->control_,'\\')+1);
		$this->view_->display($this->group_,$tplname,$classname,$this->layout);
	}

    protected function widgetDisplay($tpl=''){
        $tplname=($tpl=='')?$this->widgetPointer:$tpl;
        $classname=substr($this->control_,strrpos($this->control_,'\\')+1);
        $this->view_->display($this->group_,$tplname,$classname,'');
    }

    public function beforeAction()
    {
        return true;
    }
}