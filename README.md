一、框架说明：
这是一个力求简单的框架，设计目标是上手快，学习成本低，能根据业务需求快速拓展。采用mvc架构。
地址：https://github.com/qhgongzi/meltsnow 

二、运行流程：
1.访问url:类似www.xxx.com/index.php?c=index&a=index
                              
2.index.php:加载框架，启动框架：
    <?php
session_start();
header('Content-Type: text/html;charset=utf-8');
define('APP_PATH',dirname(__FILE__));//aae目录
require APP_PATH . '/core/Core.php';//加载框架核心
$app=CApplication::App();
$app->run();

本着简单的原则，没设置什么调试模式之类的定义，你可以在这里加入error_reporting(E_ALL)之类的显示所有错误，警告的方法。
                           
3.CApplication->run方法：
        这里会注册自动加载的函数，用于自动加载model类，核心lib类，以及用户定义的类，对应的就是框架中的model，/core/lib,class
目录，然后生成控制器类，运行控制器中的指定方法。
                        
4.用户定义的控制器：
        这里就运行到了用户自定义的代码了，开发时可以在这里写代码来实现功能。

三、控制器使用。
目录：/controller
控制器文件名：控制器名.class.php，例如:index.class.php
控制器定义：继承Controller类，
方法定义：方法作为类的公共函数，格式为action方法名。
示例：
class index extends Controller
{
    public function actionIndex(){
        echo 'melt Framework';
    }
}
四、model数据层使用。
目录：/model,应用数据层可以写在这里。
model文件名：类名.php
model定义：可以继承CMysql，也可以不继承。
数据访问：
1.继承CMysql：
CMysql会根据config里的文件来连接数据库，所以可以根据修改config文件内的变量，来实现连接不同的库。
例如：
function __construct($dbcfg="db"){
        CApplication::App()->config['db']['dbname']='user';
        parent::__construct($dbcfg);
    }
这是一个model的构造函数，这里连接了user库，其他配置根据config里的变量来。
CMysql封装了pdo的使用方法，具体见源代码

$mysql->sqlquery($sql) ,查询多条记录
$mysql->sqlqueryone($sql) ,查询一条记录
$mysql->sqlexec($sql) ,执行一条无记录的sql，例如insert，update
$mysql->sqlqueryscalar($sql) ,查询一条记录，并且只返回一个字段。
$mysql->getLastInsertId();获得最后插入的主键自增数字。

2.使用Model类
Model类封装了一系列快速访问数据库的方法。
例如这段代码：
            $mMsg=new Model('blog_message');
            $mMsg->name=addslashes(htmlspecialchars($_POST['name']));
            $mMsg->email=addslashes(htmlspecialchars($_POST['email']));
            $mMsg->aid=$aid;
            $mMsg->time=date('Y-m-d H:i:s');
            $mMsg->save();
很方便的将post过来的数据插入了表中。
添加：见上个示例
查询：
Model::model('blog_link')->order('sortid desc')->limit(5)->select();
你可以用连贯操作'where','order','limit','group','field',来进行一个查询。只要最后是
修改：
1.
$mLinks=Model::model('blog_link')->find(1001);
$mLinks->title="xx";
$mLinks->save();
2.Model::model('blog_link')->set("title='xx'",1001);
删除:
Model::model('blog_link')->where('id=1')->limit(1)->delete();
同样可以连贯操作

五、视图：
目录：/view/控制器名/
文件：控制器的方法名.php
在控制器中，可以通过$this->assign('变量',值);的办法，将变量带到视图层，然后视图就可以访问变量。
布局：布局文件保存在/view/layout/ 目录，默认main.php ,你也可以在控制器中，指定$this->layout="xxx",来调用xxx布局
weidget: 在视图文件中调用widget目录下的文件。
例如：
<div class="sidebar">
    <?php $this->widget('sidebar');?>
</div>
