<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-9-25
 * Time: 下午4:11
 * To change this template use File | Settings | File Templates.
 */

namespace core\helper;


class Algorithm {

    /**
     * @param $arr 要转换的数组
     * @param $key 要转换的key
     * @param string $value 对应值的键
     * @return array
     *
     * 将行列数组，其中的两列，对应成key=>value形式返回，如果没知名$value的值
     * 则返回 key=>这一行的数据
     */
    public static function kvResult($arr,$key,$value=''){

        $kvAry=array();

        foreach ($arr as $val) {
            if($value==''){
                $kvAry[$val["$key"]]=$val;
            }else{
                $kvAry[$val["$key"]]=$val["$value"];
            }
        }

        return $kvAry;
    }


    /**
     * @param $key 检索数组的key
     * @param array $arr 检索数组
     * @return array|mixed 检索数组中 key的所有值
     *
     * 深度遍历一个数组，将所有键名为$key的值合并返回。
     */
    public static function array_value_recursive($key, array $arr){
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val){
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : array_pop($val);
    }

}