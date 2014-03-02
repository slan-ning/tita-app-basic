<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-3-2
 * Time: 上午2:52
 */

namespace core\helper\db;

use core\Tita;

include_once dirname(__FILE__) . '/vendor/autoload.php';

/**
 * Class DB
 *
 * @package core\helper\db
 */
class DB extends \Illuminate\Database\Capsule\Manager
{

    public function getConnection($connection = null)
    {
        $config = ['driver'    => 'mysql',
                   'host'      => Tita::app()->config['db']['host'],
                   'port'      => Tita::app()->config['db']['port'],
                   'database'  => Tita::app()->config['db']['dbname'],
                   'username'  => Tita::app()->config['db']['username'],
                   'password'  => Tita::app()->config['db']['password'],
                   'charset'   => 'utf8',
                   'collation' => 'utf8_unicode_ci',
                   'prefix'    => ''
        ];

        $key = is_string($connection) ? $connection : substr(md5(serialize($connection)), 0, 8);

        if ($connection != null) {

            if (is_string($connection)) {
                $config['database'] = $key;
            } else {
                $config = $connection;
            }
        }

        parent::addConnection($config, $key);

        return $this->manager->connection($key);
    }


}

if (!defined('LOAD_Illuminate_Capsule')) {

    define('LOAD_Illuminate_Capsule', true);

    $config = ['driver'    => 'mysql',
               'host'      => Tita::app()->config['db']['host'],
               'port'      => Tita::app()->config['db']['port'],
               'database'  => Tita::app()->config['db']['dbname'],
               'username'  => Tita::app()->config['db']['username'],
               'password'  => Tita::app()->config['db']['password'],
               'charset'   => 'utf8',
               'collation' => 'utf8_unicode_ci',
               'prefix'    => ''
    ];

    $db  = new DB();
    $db->addConnection($config);
    $db->setAsGlobal();
}

