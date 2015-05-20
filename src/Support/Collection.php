<?php namespace Prontotype\Pipeline\Support;

use Amu\Sup\Arr;

class Collection implements \ArrayAccess, \Countable, \IteratorAggregate, ArrayableInterface
{
    /** @var array */
    protected $items;

    /** @var array */
    protected $metadata;

    public function __construct($items = [])
    {
        $items = is_null($items) ? [] : $this->getArrayableItems($items);
        $this->metadata = [];
        $this->items = (array) $items;
    }

    public function meta($key, $value = null)
    {
        if (is_null($value)) {
            return isset($this->metadata[$key]) ? $this->metadata[$key] : null;
        }
        $this->metadata[$key] = $this->value($value);
        return $this;
    }

    public function add($key, $value)
    {
        $this->set($key, $value);
        return $this;
    }

    public function has($key)
    {
        return $this->offsetExists($key);
    }

    public function all()
    {
        return $this->items;
    }

    public function each(callable $callback)
    {
        foreach ($this->items as $key => $item)
        {
            if ($callback($item, $key) === false) break;
        }
        return $this;
    }

    public function filter(callable $callback)
    {
        return new static(array_filter($this->items, $callback));
    }
    
    public function count()
    {
        return count($this->items);
    }

    public function merge($items)
    {
        return new static(array_merge($this->items, $this->getArrayableItems($items)));
    }

    public function toArray()
    {
        return array_map(function($value)
        {
            return $value instanceof ArrayableInterface ? $value->toArray() : $value;
        }, $this->items);
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function __toString()
    {
        return $this->toJson();
    }

    public function get($key, $fallback = null)
    {
        return isset($this->items[$key]) ? $this->items[$key] : $fallback;
    }

    public function set($key, $value)
    {
        $this->items[$key] = $this->value($value);
        return $this;
    }

    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    public function offsetGet($key)
    {
        return $this->get($key);
    }

    protected function value($value)
    {
        return $value instanceof \Closure ? $value() : $value;
    }

    protected function getArrayableItems($items)
    {
        if ($items instanceof self)
        {
            $items = $items->all();
        }
        elseif ($items instanceof ArrayableInterface)
        {
            $items = $items->toArray();
        }
        return $items;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
}
