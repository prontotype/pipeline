<?php namespace Prontotype\Pipeline\Pipe\Filter;

use Prontotype\Pipeline\Item\ItemInterface;
use Prontotype\Pipeline\Pipe\PipeInterface;
use Prontotype\Pipeline\Support\Collection;

class MetadataFilterPipe extends AbstractFilterPipe
{
    /** @var array */
    protected $value;

    protected $key;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;    
    }

    public function check(ItemInterface $item)
    {
        return $this->matches($item->get('metadata.' . $this->key, false), $this->value);
    }
}