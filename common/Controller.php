<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 4lan
 * Date: 12-8-21
 * Time: 下午4:02
 * 继承于控制器基类，用于实现一些自定义的控制器方法。
 */

namespace common;

use core\CController;

class Controller extends CController
{

    public function beforeAction()
    {
        return true;
    }
}
