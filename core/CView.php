<?php 
class CView {

	private $parm=array();
    private $control;

	
	public function __construct(&$control){
        $this->control=$control;
	}
	
	public function assign($name,$value){
		if (is_array($name)) { 
			foreach ($name as $key => $val) { 
				$this->parm[$key] = $val; 
			}	 
		} else { 
			$this->parm[$name]=$value;
		}
	}

    public function widget($func,$control='', $paramAry = array()){
        $widgetControl=$this->control;

        if($control!=''){
            $controlName=ucfirst($control)."Controller";
            $thisControllerName=get_class($this->control);

            if($thisControllerName!=$controlName){
                require(APP_PATH."/controller/".$controlName.".php");
                $widgetControl=new $controlName($controlName,$func);
            }
        }
        $widgetControl->widgetPointer=$func;
        $func="widget".$func;
        if($widgetControl->beforeAction()){
        	if(!empty($paramAry)){
                call_user_func_array(array($widgetControl,$func),$paramAry);
        	}else{
        		$widgetControl->$func();
        	}
        }
    }
	
	public function display($tpl,$classname,$lay){
		ob_start();
		extract($this->parm,EXTR_OVERWRITE );
        if(is_file(APP_PATH."/view/$classname/$tpl.php"))
		    include APP_PATH."/view/$classname/$tpl.php";
		$buffer = ob_get_contents(); 
		ob_end_clean(); 

		if($lay!=""&&is_file(APP_PATH."/view/layout/$lay.php")){
			include APP_PATH."/view/layout/$lay.php";
		}else{
			echo $buffer;
		}
		
	}

    public function __get($var){
        return $this->control->$var;
    }

}