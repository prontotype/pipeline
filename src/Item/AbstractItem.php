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
        Arr::set($this->data, $key, $this->value($value));
        return $this;
    }

    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    public function offsetExists($key)
    {
        return array_key_exists($key, $this->data);
    }

    public function offsetUnset($key)
    {
        unset($this->data[$key]);
    }

    public function offsetGet($key)
    {
        return $this->get($key);
    }

    protected function value($value)
    {
        return $value instanceof \Closure ? $value() : $value;
    }
}