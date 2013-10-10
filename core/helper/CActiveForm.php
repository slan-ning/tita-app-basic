<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-9-24
 * Time: 上午7:12
 * To change this template use File | Settings | File Templates.
 */

namespace core\helper;

abstract class CActiveForm {

    private $property;

    function __construct()
    {
        $argv=func_get_args();

        foreach ($argv as $v) {

            $this->property[$v]=null;

        }
    }


    public abstract function save();


    public function input($type,$field,$option=array())
    {
        $html='<input type="'.$type.'" ';

        foreach($option as $k=>$v){
            $html.=$k.'="'.$v.'" ';
        }

        if(!isset($option['name'])){
            $html.='name="'.$field.'" ';
        }

        if(!isset($option['value'])){
            $html.='value="'.$this->$field.'" ';
        }

        $html.=">";

        return $html;

    }

    public function textarea($field,$option=array())
    {
        $html='<textarea ';

        foreach($option as $k=>$v){
            $html.=$k.'="'.$v.'" ';
        }

        if(!isset($option['name'])){
            $html.='name="'.$field.'" ';
        }

        $html.=">".$this->$field."</textarea>";

        return $html;

    }


    public function __get($name)
    {
        if(isset($this->property[$name])){

            return $this->property[$name];

        }else{
            return false;
        }
    }

    public function __set($name,$value)
    {
        $this->property[$name]=$value;
    }


}