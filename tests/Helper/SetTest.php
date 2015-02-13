<?php
/*
 * Tiny - a micro PHP 5 framework.
 *
 * (c) tang ru cheng <tangrucheng@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use \Tiny\Helper\Set;

class SetTest extends PHPUnit_Framework_TestCase
{
    protected $bag;
    protected $property;

    public function setUp()
    {
        $this->bag = new Set();
        $this->property = new \ReflectionProperty($this->bag, 'data');
        $this->property->setAccessible(true);
    }

    public function testSet()
    {
        $this->bag->set('foo', 'bar');
        $this->assertArrayHasKey('foo', $this->property->getValue($this->bag));

        $bag = $this->property->getValue($this->bag);
        $this->assertEquals('bar', $bag['foo']);
    }

    public function testGet()
    {
        $this->property->setValue($this->bag, array('foo' => 'bar'));
        $this->assertEquals('bar', $this->bag->get('foo'));
    }

    public function testGetNotExists()
    {
        $this->assertEquals('default', $this->bag->get('abc', 'default'));
    }

}
