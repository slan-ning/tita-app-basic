## 目录结构
---------------------------

* core  框架核心目录
* model 数据访问
* view  视图目录
* index.php 访问入口

## 运行流程
---------------------------

### 入口文件

一般访问url:index.php?c=控制器名称&a=方法

入口关键代码：
```php
define('APP_PATH',dirname(__FILE__));//app base dir
require APP_PATH . '/core/Core.php';//加载框架核心

$app=\core\Tita::App();
$app->run();
```

首先包含了core文件，Core.php就干一件事，注册类的自动加载(按命令空间与目录名映射)

然后获得CApplication类，并启动。

### CApplication类

这里解析访问的路由，加载配置文件，加载需要直接加载的目录(global，如果有)，并运行对应的控制器方法。