<?php
namespace core\helper;

/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 12-12-9
 * Time: 下午10:11
 * To change this template use File | Settings | File Templates.
 */
class CPage
{
    public $dataCount; //总的数据长度
    public $pageSize; //页面显示数据长度
    public $pageNum; //当前页
    public $pageCount; //页面数
    public $pageUrl;

    function __construct($dataLen, $pagesize = 20,$pageUrl='')
    {
        $this->pageNum   =intval($_GET['p'])>0 ? intval($_GET['p']) : 1;
        $this->dataCount = intval($dataLen);
        $this->pageSize  = intval($pagesize);

        $this->pageCount = ceil($this->dataCount / $this->pageSize);

        if ($this->pageCount == 0) {
            $this->pageCount = 1;
        }
        if($pageUrl==''){
            $this->pageUrl = "http://" . $_SERVER ['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
        }else{
            $this->pageUrl=$pageUrl;
        }

        $this->pageUrl = str_replace("&p=" . $this->pageNum, "", $this->pageUrl);
    }

    function limit()
    {
        $start = ($this->pageNum - 1) * $this->pageSize;
        $limit = "$start," . $this->pageSize;

        return $limit;
    }

    function firstUrl()
    {
        return $this->pageUrl;
    }

    function endUrl()
    {
        return $this->pageUrl . "&p=" . $this->pageCount;
    }

    function nextUrl()
    {
        if ($this->pageNum < $this->pageCount) {
            return $this->pageUrl . '&p=' . ($this->pageNum + 1);
        }
    }

    function prevUrl()
    {
        if ($this->pageNum > 1) {
            return $this->pageUrl . '&p=' . ($this->pageNum - 1);
        }
    }

    /**
     * @return array
     * 中间数字分页组
     */
    function numberPage()
    {
        $start = $this->pageNum - 5;
        $start = $start > 0 ? $start : 1;
        $end   = $start + 9;
        $end   = $end < $this->pageCount ? $end : $this->pageCount;

        $page = array();

        for ($i = $start; $i <= $end; $i++) {
            $page[] = array('url'     => $this->pageUrl . '&p=' . $i,
                            'number' => $i,
                            'current' => $i == $this->pageNum ? true : false
            );
        }

        return $page;
    }

    /**
     * @return string
     * 获得分页html源码
     */
    function html()
    {
        $html = "<ul>";
        $html .= "<li><a href='" . $this->firstUrl() . "'>首页</a></li>";

        if ($this->prevUrl() != '') {
            $html .= "<li><a href='" . $this->prevUrl() . "'>上一页</a></li>";
        }

        $numberPage = $this->numberPage();

        foreach ($numberPage as $page) {
            if (!$page['current']) {
                $html .= "<li><a href='" . $page['url'] . "'>" . $page['number'] . "</a></li>";
            } else {
                $html .= "<li class=\"disabled\"><a>" . $page['number'] . "</a></li>";
            }
        }

        if ($this->nextUrl() != '') {
            $html .= "<li><a href='" . $this->nextUrl() . "'>下一页</a></li>";
        }

        $html .= "<li><a href='" . $this->firstUrl() . "'>最后一页</a></li>";

        $html .= "</ul>";

        return $html;

    }


}
