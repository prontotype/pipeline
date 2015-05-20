<?php namespace Prontotype\Pipeline\Pipe;

use Amu\Sup\Str;
use Prontotype\Pipeline\Support\Collection;

class TitleGeneratorPipe implements PipeInterface
{
    /** @var array */
    protected $ignore = ['of','a','the','and','an','or','nor','but','is','if','then','else','when','at','from','by','on','off','for','in','out','over','to','into','with'];

    public function process(Collection &$data)
    {
        $data->each(function($item){
            $item['title'] = $item->get('title', function() use ($item) {
                return Str::titleize(str_replace(array('-','_'), ' ', $item['filename']), $this->ignore);
            });
        });
    }
}

