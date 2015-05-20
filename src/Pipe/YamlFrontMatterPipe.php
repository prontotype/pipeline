<?php namespace Prontotype\Pipeline\Pipe;

use Symfony\Component\Yaml\Yaml;
use Prontotype\Pipeline\Support\Collection;

class YamlFrontMatterPipe implements PipeInterface
{
    protected $frontMatterDelimiter;

    public function __construct($frontMatterDelimiter = null)
    {
        $this->frontMatterDelimiter = $frontMatterDelimiter ?: '---';
    }

    public function process(Collection &$data)
    {        
        $data->each(function($item, $key){
            list($metadata, $body) = $this->getParts($item->get('raw'));
            foreach($metadata as $key => $value) {
                $item->set($key, $value);
            }
            $item->set('metadata', $metadata);
            $item->set('content', $body);
        });   
    }

    protected function getParts($rawContent)
    {
        $lines = explode(PHP_EOL, $rawContent);
        if (count($lines) <= 1 || rtrim($lines[0]) !== $this->frontMatterDelimiter) {
            $metadata = [];
            $body = $rawContent;
            return [$metadata, $body];
        }
        unset($lines[0]);
        $yaml = [];
        $i = 1;
        foreach ($lines as $line) {
            if ($line === $this->frontMatterDelimiter) {
                break;
            }
            $yaml[] = $line;
            $i++;
        }
        $metadata = Yaml::parse(implode(PHP_EOL, $yaml));
        $body = implode(PHP_EOL, array_slice($lines, $i));
        return [$metadata, $body];
    }

}