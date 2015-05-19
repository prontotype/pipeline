<?php namespace Prontotype\Pipeline\Pipe;

use Prontotype\Pipeline\Support\Collection;
use League\CommonMark\CommonMarkConverter;

class MarkdownParserPipe implements PipeInterface
{
    /** @var CommonMarkConverter */
    protected $converter;

    /** @var type */
    protected $mdExtensions = ['md', 'markdown'];

    public function __construct()
    {
        $this->converter = new CommonMarkConverter();
    }
    
    public function process(Collection &$data)
    {
        $data->each(function($item, $key){
            if ($this->isMarkdown($item)) {
                $content = $this->converter->convertToHtml($item->get('content'));
                $item->set('content', $content);
            }
        });
    }

    protected function isMarkdown($item)
    {
        return in_array($item->get('extension'), $this->mdExtensions);
    }
}