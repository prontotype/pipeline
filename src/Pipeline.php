<?php namespace Prontotype\Pipeline;

use Prontotype\Pipeline\Input\DirectoryInput;
use Prontotype\Pipeline\Input\InputInterface;
use Prontotype\Pipeline\Output\DirectoryOutput;
use Prontotype\Pipeline\Output\OutputInterface;
use Prontotype\Pipeline\Pipe\PipeInterface;
use Prontotype\Pipeline\Support\Collection;
use Prontotype\Pipeline\Pipe;

class Pipeline implements \IteratorAggregate
{
    /** @var string */
    protected $input;

    /** @var array */
    protected $data;

    protected $defaultPipes = [
        'Prontotype\Pipeline\Pipe\YamlFrontMatterPipe',
        'Prontotype\Pipeline\Pipe\IdGeneratorPipe',
        'Prontotype\Pipeline\Pipe\TitleGeneratorPipe'
    ];

    public function __construct($input)
    {
        $this->input = $input instanceof InputInterface ? $input : new DirectoryInput($input);
        $this->data = $this->input->data();
        $this->processDefaultPipes();
    }

    public function pipe($pipe)
    {
        if (! $pipe instanceof PipeInterface) {
            $pipe = new $pipe();
        }
        $pipe->process($this->data);
        return $this;
    }

    public function data()
    {
        return $this->data;
    }

    public function merge(Pipeline $pipeline)
    {
        $this->data->merge($pipeline->data());
        return $this;
    }

    public function output($output)
    {
        $output = $output instanceof OutputInterface ? $output : new DirectoryOutput($output);
        $output->data($this->data);
        return $this;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->data->toArray());
    }

    protected function processDefaultPipes()
    {
        foreach($this->defaultPipes as $pipe) {
            $this->pipe($pipe);
        }
    }

}