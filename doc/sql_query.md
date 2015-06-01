##数据库操作示例

###前置表


```sql
CREATE TABLE `user` (
`id`  int NOT NULL ,
`username`  varchar(20) NOT NULL ,
`nick`  varchar(20) NULL ,
PRIMARY KEY (`id`)
)
;
```

###原生PDO
1. 插入
```php
$mysql =new \core\helper\db\CMysql();
$mysql->sqlexec("insert into USER VALUE (null,'4lan','翟四岚')");
```

2. 查询
```php
$mysql =new \core\helper\db\CMysql();
$mysql->sqlqueryone("select * from user where username='4lan'");//查询一条

$mysql->sqlquery("select * from user where id>1");//查询所有id>1的记录

$nick=$mysql->sqlqueryscalar("select nick from user where username='4lan'");//直接取第一行，第一个字段
```


###laravel db 快捷操作
框架整合了laravel的数据库操作功能，封装了\core\helper\db\DB (查询构造器) \core\helper\db\Model (orm)

文档地址: [http://www.golaravel.com/laravel/docs/5.0/queries/](http://www.golaravel.com/laravel/docs/5.0/queries/)

1. 插入
```php
\core\helper\db\DB::connection()->table('user')->insert(['id'=>null,'username'=>'4lan','nick'=>'翟四岚']);
```

2. 查询
```php
\core\helper\db\DB::connection()->table('user')->where('id','>',1)->get();//返回大于1的记录
```

