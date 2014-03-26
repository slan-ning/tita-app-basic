<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-9-25
 * Time: 下午4:11
 * To change this template use File | Settings | File Templates.
 */

namespace core\helper;


class Algorithm
{

    /**
     * 将行列数组，其中的两列，对应成key=>value形式返回，如果没知名$value的值
     * 则返回 key=>这一行的数据
     *
     * @param array  $arr   要转换的数组
     * @param string $key   要转换的key
     * @param string $value 对应值的键
     *
     * @return array
     */
    public static function kvResult($arr, $key, $value = '')
    {

        $kvAry = array();

        foreach ((array)$arr as $val) {
            if ($value == '') {
                $kvAry[$val["$key"]] = $val;
            } else {
                $kvAry[$val["$key"]] = $val["$value"];
            }
        }

        return $kvAry;
    }

    /**
     * 深度遍历一个数组，将所有键名为$key的值合并返回。
     *
     * @param string $key 检索数组的key
     * @param array  $arr 检索数组
     *
     * @return array|mixed 检索数组中 key的所有值
     */
    public static function array_value_recursive($key, array $arr)
    {
        $val = array();
        array_walk_recursive(
            $arr, function ($v, $k) use ($key, &$val) {
                if ($k == $key) {
                    array_push($val, $v);
                }
            }
        );
        return count($val) > 1 ? $val : array_pop($val);
    }


    /**
     * 生成一个树(调用部分)
     *
     * @param array  $arr       输入数组
     * @param string $parentKey 父id的键名 如:pid
     * @param int    $level     当前深度
     *
     * @return array
     */
    public static function array_build_tree($arr, $parentKey, $level = 0)
    {
        $ret = array();
        foreach ($arr as $k => $v) {
            if ($v[$parentKey] == $level) {
                $tmp = $arr[$k];
                unset($arr[$k]);
                $tmp['child'] = self::array_build_tree($arr, $parentKey, $v['id']);
                $ret[]        = $tmp;
            }
        }
        return $ret;
    }

}