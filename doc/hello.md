##Tita hello world

###获取框架代码
1. 下载项目源代码，并放置于web目录
2. 配置config.php文件(数据库访问信息)
3. 执行composer update (如何使用composer请google)

###创建控制器
1. 在controller目录下新建hello.php
2. 在hello.php 声明命名空间，新建一个hello类 
```php
<?php
namespace controller;


use common\Controller;

class hello extends Controller{

    public function actionIndex(){
        $data=!empty($_GET['name'])?$_GET['name']:'world';
        $this->assign('data',$data);
        $this->display();
    }

}
```
上面这段代码新建了一个hello控制器，并且把收到的数据传递给视图，并渲染视图


###创建视图
1. 在view目录建立一个叫hello的文件夹，存放hello控制器里所有的视图文件
2. 在hello文件夹建立一个index.php的视图文件(对应Index方法的小写名称)
3. 添加视图内容
```html
<html>
<body>
hello <?php echo $data;?>
</body>
</html>
```
4. 访问http://项目地址/index.php?c=hello&a=index 

