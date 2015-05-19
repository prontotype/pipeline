<?php namespace Prontotype\Pipeline\Output;

use Amu\Sup\Path;
use Prontotype\Pipeline\Support\Collection;

class DirectoryOutput implements OutputInterface
{
    /** @var string */
    protected $outputPath;

    public function __construct($outputPath)
    {
        $this->outputPath = $outputPath;
    }

    public function data(Collection $data)
    {
        $this->deleteDir($this->outputPath);
        mkdir($this->outputPath, 0777, true);
        $data->each(function($item, $key){
            $relDir = Path::join($this->outputPath, $item->get('rel_path'));
            if (!is_dir($relDir)) {
                mkdir($relDir, 0777, true);
            }
            file_put_contents(Path::join($this->outputPath, $item->get('rel_pathname')), $item->get('content'));
        });
    }

    protected function deleteDir($path)
    {
        if (empty($path) || trim($path) === '/') {
            throw new \RuntimeException('Incomplete path set');
        }
        if (file_exists($path)) {
            exec("rm -rf {$path}");    
        }
    }
}
