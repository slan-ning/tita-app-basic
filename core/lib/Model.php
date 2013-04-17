<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 4lan
 * Date: 12-7-28
 * Time: 下午1:44
 * To change this template use File | Settings | File Templates.
 */
class Model extends CMysql
{
    private $attributes;
    private $table;
    private $isNew=true;
    private $prikey;

    private $_field;
    private $_limit;
    private $_order;
    private $_where;
    private $_group;

    public static function model($table)
    {
        $model= new Model($table);
        return $model;
    }


    public function __construct($tablename){
        parent::__construct();
        $this->table=$tablename;
        //获得所有的字段
        $sql="desc `".$this->table."`";
        $field=$this->sqlquery($sql);

        foreach($field as $val){
            $this->attributes[$val['Field']]=null;
            if($val['Key']=='PRI'){
                $this->prikey=$val['Field'];
            }
        }

    }

    public function select($pk=0){
        if($pk==0){
            $fields=empty($this->_field)?'*':$this->_field;
            $wheres=empty($this->_where)?'':('where '.$this->_where);
            $limits=empty($this->_limit)?'':('limit '.$this->_limit);
            $orders=empty($this->_order)?'':('order by '.$this->_order);
            $groups=empty($this->_group)?'':('group by '.$this->_group);

            $sql="select $fields from `".$this->table."` $wheres $orders $groups $limits";

            $data=$this->sqlquery($sql);
            return $data;
        }elseif(is_numeric($pk)){
            $fields=empty($this->_field)?'*':$this->_field;
            $wheres="where ".$this->prikey."=$pk";
            $sql="select $fields from `".$this->table."` $wheres ";
            return $this->sqlqueryone($sql);
        }
    }
    /*
     * 数据记录删除函数，调用需加where以及limit连贯操作  ，如删除全表，请设置参数sign为true
     * 如未加连贯操作，并且sign为false，则不删除全表，直接返回false。
     */
    public function delete($pk=0,$sign=false){
        if($pk==0){
            $wheres=empty($this->_where)?'':('where '.$this->_where);
            $limits=empty($this->_limit)?'':('limit '.$this->_limit);
            if($wheres==""&& $limits="" &&$sign=false){
                return false;
            }
            $sql="delete from `".$this->table."` $wheres $limits";
            return $this->sqlexec($sql);
        }elseif(is_numeric($pk)){
            $wheres="where ".$this->prikey."=$pk";
            $sql="delete from `".$this->table."` $wheres limit 1";
            return $this->sqlexec($sql);
        }

    }


    /*
    * 数据记录修改函数，调用需加where以及limit连贯操作  ，如删除全表，请设置参数sign为true
    * 如未加连贯操作，并且sign为false，则不删除全表，直接返回false。
    */
    public function set($sets,$pk=0,$sign=false){
        if($pk==0){
            $wheres=empty($this->_where)?'':('where '.$this->_where);
            $limits=empty($this->_limit)?'':('limit '.$this->_limit);
            if($wheres==""&& $limits="" &&$sign=false){
                return false;
            }
            $sql="update `".$this->table."` set $sets $wheres $limits";
            return $this->sqlexec($sql);
        }elseif(is_numeric($pk)){
            $wheres="where ".$this->prikey."=$pk";
            $sql="update `".$this->table."` set $sets $wheres limit 1";
            return $this->sqlqueryone($sql);
        }
    }

    public function save(){
        $keys="`".implode('`,`',array_keys($this->attributes))."`";

        $vals=array_values($this->attributes);
        foreach($vals as &$v){
            if(!is_numeric($v)){
                $v='\''.$v.'\'';
            }
        }
        $values=implode(',',$vals);

        if($this->isNew){
            $sql="Insert into `".$this->table."` ($keys) values($values)";
            return $this->sqlexec($sql);
        }else{
            $upvalue="";
            $num=count($this->attributes);
            $i=0;
            foreach($this->attributes as $key=>$v){
                $i++;
                if($this->prikey==$key) continue;
                if(!is_numeric($v)){
                    $v='\''.$v.'\'';
                }
                $upvalue.="`$key`=$v";
                if($i!=$num) $upvalue.=', ';
            }
            $sql="update `".$this->table."` set $upvalue where ".$this->prikey."=".$this->attributes[$this->prikey];
            return $this->sqlexec($sql);
        }
    }

    //根据条件获得一个实例
    public function find($param){
        $keys="`".implode("`,`",array_keys($this->attributes))."`";
        if(is_numeric($param))
        {
            $sql="select $keys from `".$this->table."` where ".$this->prikey."=$param";
        }else{
            $sql="select $keys from `".$this->table."` where $param limit 1";
        }

        $data=$this->sqlqueryone($sql);
        if($data)
        {
            $this->isNew=false;
            foreach($data as $key=>$v)
            {
                $this->attributes[$key]=$v;
            }
            return $this;
        }else{
            return false;
        }

    }



    public function __get($name){
        return $this->attributes[$name];
    }

    public function __set($name,$value){
        $this->attributes[$name]=$value;
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    public function __call($method,$args) {
        if(in_array(strtolower($method),array('where','order','limit','group','field'),true)) {
            $method='_'.$method;
            $this->$method =   $args[0];
            return $this;
        }else{
            return;
        }
    }



}
