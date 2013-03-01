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

    public function widget($file){
        extract($this->parm,EXTR_OVERWRITE );
        if(is_file(APP_PATH."/view/widget/$file.php"))
            include APP_PATH."/view/widget/$file.php";
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