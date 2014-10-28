<?php
namespace core;

use core\helper\db\DB;

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

    public function widget($func, $control='', $paramAry = array(), $group=''){
        $widgetControl=$this->control;

        if($control!=''){
            $controlName= $group=='' ? 'controller\\'.$control : $group.'\controller\\'.$control;

            $thisControllerName=get_class($this->control);

            if($thisControllerName!=$controlName)
            {

                $widgetControl=new $controlName($group,$controlName,$func);

            }
        }

        $widgetControl->widgetPointer=$func;//保存widget名称，用来定位widget模版

        $func="widget".$func;
        if($widgetControl->beforeAction()){
        	if(!empty($paramAry)){
                return call_user_func_array(array($widgetControl,$func),$paramAry);
        	}else{
        		return $widgetControl->$func();
        	}
        }
    }
	
	public function display($group_,$tpl_,$classname_,$lay_){
        $tplPath_=$group_==''?APP_PATH."/view/":APP_PATH.'/'.$group_."/view/";

		ob_start();
		extract($this->parm,EXTR_OVERWRITE );

        ///加载模版文件
        if(is_file($tplPath_."$classname_/$tpl_.php"))
		    include $tplPath_."$classname_/$tpl_.php";

		$buffer = ob_get_contents(); 
		ob_end_clean(); 

        //加载布局文件
		if($lay_!=""&&is_file($tplPath_."layout/$lay_.php")){
			include $tplPath_."layout/$lay_.php";
		}else{
			echo $buffer;
		}
		
	}


    public function __get($var){
        return $this->control->$var;
    }

}