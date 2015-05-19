<?php namespace Prontotype\Pipeline\Pipe\Filter;

use Prontotype\Pipeline\Item\ItemInterface;
use Prontotype\Pipeline\Pipe\PipeInterface;
use Prontotype\Pipeline\Support\Collection;

abstract class AbstractFilterPipe implements PipeInterface
{
    public function process(Collection &$data)
    {
        $data = $data->filter(function($item){
            return $this->check($item);
        });
    }

    public function matches($value, $test)
    {
        $opts = array_map(function($val){
            return strtolower($val);
        }, explode('|', $test));
        return in_array($value, $opts);
    }

    abstract public function check(ItemInterface $item);
}