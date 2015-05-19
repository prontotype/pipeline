<?php namespace Prontotype\Pipeline\Item;

use Amu\Sup\Str;
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
        $this['is_dir']     = $this->file->isDir();
        $this['is_file']    = $this->file->isFile();
        $this['filename']   = $this->file->getFilename();
        $this['extension']  = strtolower($this->file->getExtension());
        $this['basename']   = $this->file->getBasename();
        $this['mtime']      = $this->file->getMTime();
        $this['path']       = $this->file->getPath();
        $this['pathname']   = $this->file->getPathname();
        $this['rel_path']   = $this->makeRelPath($this->file->getPath());
        $this['rel_pathname'] = $this->makeRelPath($this->file->getPathname());
    }

    protected function makeRelPath($path)
    {
        return trim(Str::regexReplace($path, '^'.$this->cwd, ''),'/');
    }
}