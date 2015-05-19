<?php namespace Prontotype\Pipeline\Pipe\Filter;

use Prontotype\Pipeline\Item\ItemInterface;
use Prontotype\Pipeline\Pipe\PipeInterface;
use Prontotype\Pipeline\Support\Collection;

class ExtensionFilterPipe extends AbstractFilterPipe
{
    /** @var array */
    protected $ext;

    public function __construct($ext)
    {
        $this->ext = $ext;
    }

    public function check(ItemInterface $item)
    {
        return $this->matches($item->get('extension'), $this->ext);
    }
}