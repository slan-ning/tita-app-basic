<?php
namespace core\helper;

use core\CApplication;
use PDO;
use PDOStatement;

/**
 * 封装PDO的mysql操作类，更简单更方便的使用pdo
 * 出于安全原因，不建议使用sqlxxxx快捷方法去直接操作数据库。
 * 对于有外部参数影响的sql，应使用pre方法预处理，然后绑定参数执行。
 * Class CMysql
 *
 * @package core\helper
 */
class CMysql
{
    /**
     * @var PDOStatement
     */
    protected $stmt;
    /**
     * @var PDO
     */
    protected $db;
    protected $dbhost;
    protected $dbname;
    private $dbuser;
    private $dbpasw;
    private $port;

    /**
     * 构造函数。
     *
     * @param string|array $dbcfg 直接传config.php中的数据库配置key，或者数据库配置数组
     *
     * @throws \Exception
     */
    function __construct($dbcfg = "db")
    {
        if (is_string($dbcfg)) {
            $dbcfg = CApplication::app()->config[$dbcfg];
        }

        $this->dbhost = $dbcfg['host'];
        $this->dbuser = $dbcfg['username'];
        $this->dbpasw = $dbcfg['password'];
        $this->dbname = $dbcfg['dbname'];
        $this->port   = $dbcfg['port'];

        $dsn = "mysql:host=$this->dbhost;port=$this->port;dbname=$this->dbname;charset=utf8";

        try {
            $this->db = new \PDO($dsn, $this->dbuser, $this->dbpasw);
        } catch (\PDOException $e) {
            throw new \Exception( '数据库连接失败:'. $e->getMessage());
        }
        $this->db->query("set names utf8");

    }

    /**
     * 直接执行sql语句
     *
     * @param $sql
     *
     * @return int
     */
    public function sqlexec($sql)
    {
        $result = $this->db->exec($sql);

        return $result;
    }

    /**
     * 执行一条sql语句，并且获得所有结果
     *
     * @param $sql
     *
     * @return array|null
     */
    public function sqlquery($sql)
    {
        $stmt = $this->db->query($sql);

        if (empty($stmt)) {
            return null;
        }

        $result = $stmt->fetchAll(\pdo::FETCH_ASSOC);

        return $result;
    }

    /**
     * 执行一条sql语句，获得单行结果
     *
     * @param $sql
     *
     * @return mixed|null
     */
    public function sqlqueryone($sql)
    {
        $stmt = $this->db->query($sql);

        if (empty($stmt)) {
            return null;
        }
        $result = $stmt->fetch(\pdo::FETCH_ASSOC);

        return $result;
    }

    /**
     * 执行一条sql语句，获得一列的值
     *
     * @param     $sql
     * @param int $column 第几列
     *
     * @return null|string
     */
    public function sqlqueryscalar($sql, $column = 0)
    {
        $stmt = $this->db->query($sql);

        if (empty($stmt)) {
            return null;
        }
        $result = $stmt->fetchColumn($column);

        return $result;
    }

    /**
     * 预处理，生成PDOStatement
     *
     * @param $sql
     */
    public function pre($sql)
    {
        $this->stmt = $this->db->prepare($sql);
    }

    /**
     * 绑定数字到PDOStatement
     *
     * @param $key
     * @param $val
     */
    public function bindIntParam($key, $val)
    {
        $this->stmt->bindParam($key, $val, \PDO::PARAM_INT);
    }

    /**
     * 绑定字符串到PDOStatement
     *
     * @param $key
     * @param $val
     */
    public function bindStrParam($key, $val)
    {
        $this->stmt->bindParam($key, $val, \PDO::PARAM_STR);
    }

    /**
     * 开始事务
     */
    public function beginTransaction()
    {
        $this->db->beginTransaction();
    }

    /**
     * 提交事务
     */
    public function commit()
    {
        if($this->db->inTransaction())
            $this->db->commit();
    }

    /**
     * 回滚事务
     */
    public function rollBack()
    {
        if($this->db->inTransaction())
            $this->db->rollBack();
    }

    /**
     * 最后插入id
     *
     * @return string
     */
    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * 获取stmt的一行数据
     *
     * @return mixed
     */
    public function fetch()
    {
        return $this->stmt->fetch(\pdo::FETCH_ASSOC);
    }

    /**
     * 以数组模式，返回PDOStatement所有记录
     *
     * @return array
     */
    public function fetchAll()
    {
        return $this->stmt->fetchAll(pdo::FETCH_ASSOC);
    }

    /**
     * 返回PDOStatement结果的第几列的第一行数据
     *
     * @param $column 列数
     *
     * @return string
     */
    public function fetchColumn($column)
    {
        return $this->stmt->fetchColumn($column);
    }

    public function __call($method, $args)
    {
        if (in_array($method, array('errorCode', 'errorInfo', 'execute', 'rowCount'))) {
            return call_user_func_array(array($this->stmt, $method), $args);
        }
    }

    /**
     * @desc 关闭数据库长连接
     */
    public function closedb(){
        unset($this->db);
    }

}