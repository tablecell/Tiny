<?php
/*
 * Tiny - a micro PHP 5 framework.
 *
 * (c) tang ru cheng <tangrucheng@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tiny\Helper;

class Set implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * 键值对数组数据
     *
     * @var array
     */
    protected $data = array();

    /**
     * Constructor
     *
     * @param array $items 键值对数组
     */
    public function __construct(array $items = array())
    {
        $this->replace($items);
    }

    /**
     * 标准化数据的key
     *
     * @param string $key 数据的key
     * @return mixed
     */
    protected function normalizeKey($key)
    {
        return $key;
    }

    public function __isset($key)
    {
        return $this->has($key);
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    public function __unset($key)
    {
        $this->remove($key);
    }

    /**
     * IteratorAggregate
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * ArrayAccess
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * ArrayAccess
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * ArrayAccess
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * ArrayAccess
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * Countable
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * 获取所有数据
     *
     * @return array
     */
    public function add()
    {
        return $this->data;
    }

    /**
     * 替换
     *
     * @param array $items 键值对数组
     */
    public function replace(array $items)
    {
        foreach ($items as $key => $value) {
            $this->set($this->normalizeKey($key), $value);
        }
    }

    /**
     * 获取数据的所有key
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->data);
    }

    /**
     * 是否包含指定key
     *
     * @param string $key 数据的key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($this->normalizeKey($key), $this->data);
    }

    /**
     * 获取指定key的数据
     *
     * @param $key
     * @param mixed $default 如果指定key的数据不存在则使用此数据代替
     * @return mixed 指定key的数据或默认值
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            $isInvokable = is_object($this->data[$this->normalizeKey($key)]) && method_exists($this->data[$this->normalizeKey($key)], '__invoke');
            return $isInvokable ? $this->data[$this->normalizeKey($key)]($this) : $this->data[$this->normalizeKey
            ($key)];
        }

        return $default;
    }

    /**
     * 设置数据
     *
     * @param string $key 数据的key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->data[$this->normalizeKey($key)] = $value;
    }

    /**
     * 删除指定key的数据
     *
     * @param string $key 数据的key
     */
    public function remove($key)
    {
        unset($this->data[$this->normalizeKey($key)]);
    }



    /**
     * 清除所有数据
     */
    public function clear()
    {
        $this->data = array();
    }



    /**
     * 单例
     *
     * @param $key
     * @param \Closure $value 匿名函数
     */
    public function singleton($key, $value)
    {
        $this->set($key, function ($c) use ($value) {
            static $object;

            if (null === $object) {
                $object = $value($c);
            }

            return $object;
        });
    }

    public function protect()
    {
        // TODO
    }
}
