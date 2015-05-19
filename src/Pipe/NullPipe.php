<?php namespace Prontotype\Pipeline\Pipe;

use Prontotype\Pipeline\Support\Collection;

class NullPipe implements PipeInterface
{
    public function process(Collection &$data)
    {
        // do nothing
    }
}