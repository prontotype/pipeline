<?php namespace Prontotype\Pipeline\Support;

class Collection implements \ArrayAccess, \Countable, \IteratorAggregate, ArrayableInterface
{
    /** @var array */
    protected $items;

    public function __construct($items = [])
    {
        $items = is_null($items) ? [] : $this->getArrayableItems($items);
        $this->items = (array) $items;
    }

    public function add($key, $value)
    {
        $this->offsetSet($key, $value);
        return $this;
    }

    public function has($key)
    {
        return $this->offsetExists($key);
    }

    public function get($key, $fallback = null)
    {
        return isset($this->items[$key]) ? $this->items[$key] : $fallback;
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

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$key];
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
