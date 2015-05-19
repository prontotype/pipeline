<?php namespace Prontotype\Pipeline\Item;

use Amu\Sup\Arr;
use Prontotype\Pipeline\Support\ArrayableInterface;

abstract class AbstractItem implements \ArrayAccess, ArrayableInterface, ItemInterface
{
    /** @var array */
    protected $data = [];

    public function toArray()
    {
        return $this->data;
    }

    public function get($key, $fallback = null)
    {
        return Arr::get($this->data, $key, $fallback);
    }

    public function set($key, $value)
    {
        $this->offsetSet($key, $value);
        return $this;
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$key];
    }
}