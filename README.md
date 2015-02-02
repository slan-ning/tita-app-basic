## 框架说明

### 关于tita

tita是一个简单的php框架，提供了基本的mvc分层功能，以及一些常用工具，tita引入composer来管理包，使得可以尽依赖庞大的composer第三方库资源。

### 需要基本环境支持
* php5.4以上
* pdo-mysql拓展

> 如果使用按目录访问控制器分组功能，需要启用apache mod_rewrite模块

### 安装使用
1. 下载项目源代码，并放置于web目录
2. 配置config.php文件(数据库访问信息)
3. 执行composer update 
4. 访问并enjoy it。

## 文档

###demo
[hello world](doc/hello.md)

[简单数据库查询](doc/sql_query.md)

[留言板](doc/guest_book.md)

###控制器
[点击查看](doc/controller.md)

###数据库操作
[点击查看](doc/mysql.md)

###Model,包约定
[点击查看](doc/model.md)

###view 视图
[点击查看](doc/view.md)

###composer 如何引入第三方库
[点击查看](doc/composer.md)

###提供的一些helper class
[点击查看](doc/helper.md)

###路径以及url
[点击查看](doc/url.md)
