<?php namespace Prontotype\Pipeline\Pipe;

use Amu\Sup\Path;
use Prontotype\Pipeline\Support\Collection;

class ComponentCollectorPipe implements PipeInterface
{
    /** @var array */
    protected $match;

    public function __construct($match = [])
    {
        $this->match = $match;
    }

    public function process(Collection &$data)
    {
        $data->each(function($item, $key) use ($data) {
            if ($this->isComponent($item)) {
                foreach ($data as &$file) {
                    if ($file['rel_path'] == $item['rel_path'] && $item['id'] !== $file['id']) {
                        // in the same directory, but not the same file
                        $this->createRelationship($item['id'], $file);
                    }
                    if (in_array($file['id'], (array) $item->get('related', []))) {
                        // in the 'related' array in metadata
                        $this->createRelationship($item['id'], $file);
                    }
                    $file['belongs_to'] = array_unique($file->get('belongs_to',[]));
                }
            }
        });
    }

    protected function createRelationship($parentId, &$child)
    {
        $child['belongs_to'] = array_merge($child->get('belongs_to',[]), [$parentId]);
    }

    protected function isComponent($item)
    {
        return in_array($item['extension'], $this->match);
    }
}