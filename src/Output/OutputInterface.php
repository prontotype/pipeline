<?php namespace Prontotype\Pipeline\Output;

use Prontotype\Pipeline\Support\Collection;

interface OutputInterface
{
    public function data(Collection $data);
}