<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 12-12-26
 * Time: 上午11:49
 * To change this template use File | Settings | File Templates.
 */
namespace controller;

use common\Controller;
use core\helper\Event;

class index extends Controller
{
    public function actionIndex(){

        echo 'tita framework';
    }

    public function actionTestEventFire()
    {
        Event::create()->listen('event.fired',function($msg){
                echo 'got it!',$msg;
            });

        Event::create()->fire('event.fired','fire in hole!');
    }
}
