<?php namespace Prontotype\Pipeline\Item;

use Amu\Sup\Str;
use Amu\Sup\path;
use Prontotype\Pipeline\Support\ArrayableInterface;

class FileItem extends AbstractItem
{
    /** @var SplFileInfo */
    protected $file;

    /** @var string */
    protected $cwd;

    public function __construct(\SplFileInfo $file, $cwd)
    {
        $this->file = $file;
        $this->cwd = $cwd;
        $this->setInitialData();
    }

    protected function setInitialData()
    {
        $contents = file_get_contents($this->file->getPathname());
        $this['raw']        = $contents;
        $this['content']    = $contents;
        $this['filename']   = str_replace('.' . $this->file->getExtension(), '', $this->file->getBasename());
        $this['extension']  = strtolower($this->file->getExtension());
        $this['basename']   = $this->file->getBasename();
        $this['mtime']      = $this->file->getMTime();
        $this['path']       = $this->file->getPath();
        $this['pathname']   = $this->file->getPathname();
        $this['rel_path']   = $this->makeRelPath($this->file->getPath());
        $this['rel_pathname'] = $this->makeRelPath($this->file->getPathname());
        $this['rel_depth']  = count(explode('/', $this['rel_path']));
        $this['metadata']   = [];
    }

    protected function makeRelPath($path)
    {
        return trim(Str::regexReplace($path, '^'.$this->cwd, ''),'/');
    }
}