<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 12-12-9
 * Time: 下午10:11
 * To change this template use File | Settings | File Templates.
 */
class CPage
{
    public $dataCount;//总的数据长度
    public $pageSize;//页面显示数据长度
    public $pageNum;//当前页
    public $pageCount;//页面数
    public $pageUrl;

    function __construct($dataLen,$pagesize=20){
        $this->pageNum=isset($_GET['p'])?$_GET['p']:1;
        $this->dataCount=$dataLen;
        $this->pageSize=$pagesize;

        $this->pageCount=ceil($this->dataCount/$this->pageSize);
        
        if($this->pageCount==0)$this->pageCount=1;
        $this->pageUrl="http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
        $this->pageUrl=str_replace("&p=".$this->pageNum,"",$this->pageUrl);
    }

    function getLimit(){
        $start=($this->pageNum-1)*$this->pageSize;
        $limit="$start,".$this->pageSize;
        return $limit;
    }

    function getPageHtml(){
        //按总页数判断输出页码
        // 1 2 3 4 5 6 7 8 9 10 11 12
        //总页数不大于11条时
        if($this->pageCount <= 11){

            $html= "<ul>";
            $html.= "<li><a href='".$this->pageUrl."'>第一页</a></li>";

            for($i = 1; $i <= $this->pageCount; $i++){
                if($this->pageNum!=$i){
                    $html.= "<li><a href='".$this->pageUrl."&p=".$i."'>".$i."</a></li>";
                }else{
                    $html.= "<li class=\"disabled\"><a>$i</a></li>";
                }

            }

            $html.= "<li><a href='".$this->pageUrl."&p=".$this->pageCount."'>最后一页</a></li>";
            $html.= "</ul>";
            return $html;

        }else{

            //当页数大于11条时
            //---------------------------------
            if($this->pageNum <= 6){

                $html= "<ul>";
                $html.= "<li><a href='".$this->pageUrl."'>第一页</a></li>";

                for($i = 1; $i <= 11; $i++){
                    if($this->pageNum!=$i){
                        $html.= "<li><a href='".$this->pageUrl."&p=".$i."'>".$i."</a></li>";
                    }else{
                        $html.= "<li class=\"disabled\"><a>$i</a></li>";
                    }
                }

                $html.= "<li><a href='".$this->pageUrl."&p=".$this->pageCount."'>最后一页</a></li>";
                $html.= "</ul>";
                return $html;

            }

            if($this->pageCount - $this->pageNum <=6){

                $html= "<ul>";
                $html.= "<li><a href='".$this->pageUrl."'>第一页</a></li>";

                for($i = $this->pageCount - 11; $i <= $this->pageCount ; $i++){
                    if($this->pageNum!=$i){
                        $html.= "<li><a href='".$this->pageUrl."&p=".$i."'>".$i."</a></li>";
                    }else{
                        $html.= "<li class=\"disabled\"><a>$i</a></li>";
                    }
                }

                $html.= "<li><a href='".$this->pageUrl."&p=".$this->pageCount."'>最后一页</a></li>";
                $html.= "</ul>";
                return $html;

            }

            if($this->pageNum > 6 && $this->pageNum < $this->pageCount - 6){

                $html= "<ul>";
                $html.= "<li><a href='".$this->pageUrl."'>第一页</a></li>";

                for($j = $this->pageNum - 5; $j <= $this->pageNum + 5; $j++){
                    if($this->pageNum!=$j){
                        $html.= "<li><a href='".$this->pageUrl."&p=".$j."'>".$j."</a></li>";
                    }else{
                        $html.= "<li class=\"disabled\"><a>$j</a></li>";
                    }
                }

                $html.= "<li><a href='".$this->pageUrl."&p=".$this->pageCount."'>最后一页</a></li>";
                $html.= "</ul>";
                return $html;

            }

        }
    }


}
