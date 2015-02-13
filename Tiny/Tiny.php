<?php
/*
 * Tiny - a micro PHP 5 framework.
 *
 * (c) tang ru cheng <tangrucheng@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tiny;

use \Tiny\Helper\Set;

class Tiny
{
    /**
     * @var Set
     */
    public $container;

    /**
     * Constructor
     *
     * @param array $userSettings 自定义配置
     */
    public function __construct(array $userSettings = array())
    {
        // 设定依赖注入容器
        $this->container = new Set();

        $this->container['settings'] = array_merge(static::getDefaultSettings(), $userSettings);

        // 环境

        // 请求

        // 响应

        // 路由
        $this->container->singleton('router', function ($c) {
            new Router();
        });

        // 视图

        // 日志

    }

    public function __get($name)
    {
        return $this->container[$name];
    }

    public function __set($name, $value)
    {
        $this->container[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->container[$name]);
    }

    public function __unset($name)
    {
        unset($this->container[$name]);
    }

    /**
     * 默认配置
     *
     * @return array
     */
    public static function getDefaultSettings()
    {
        return array();
    }

    /********************************************************************************
     * 路由
     *******************************************************************************/

    /**
     *
     */
    protected function mapRoute($args)
    {
        $pattern = array_shift($args);
        $callable = array_pop($args);
    }

    // GET
    public function get()
    {
        $args = func_get_args();
        return $this->mapRoute($args);
    }

    // POST

    // PUT

    // DELETE

    // OPTIONS

    // PATCH


}
