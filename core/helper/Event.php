<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-3-2
 * Time: 下午10:39
 */

namespace core\helper;

include_once dirname(__FILE__) . '/db/vendor/autoload.php';

/**
 * Class Event
 *
 * @package core\helper
 */
class Event extends \Illuminate\Events\Dispatcher
{

    private static $m_instance;

    public static function create()
    {
        if (!isset(self::$m_instance)) {

            self::$m_instance = new Event();
        }
        return self::$m_instance;
    }

} 