<?php namespace Prontotype\Pipeline\Pipe;

use Prontotype\Pipeline\Support\Collection;

interface PipeInterface
{
    public function process(Collection &$data);
}