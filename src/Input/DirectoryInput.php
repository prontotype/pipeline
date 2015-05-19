<?php namespace Prontotype\Pipeline\Input;

use Prontotype\Pipeline\Support\Collection;
use Prontotype\Pipeline\Item\FileItem;

class DirectoryInput implements InputInterface
{
    /** @var string */
    protected $dir;

    /** @var type */
    protected $files;

    public function __construct($dir)
    {
        if (!is_dir($dir)) {
            throw new \RuntimeException('Directory not found');
        }
        $this->dir = $dir;
    }

    public function data()
    {
        if (!$this->files) {
            $files = new Collection();
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->dir, \FilesystemIterator::SKIP_DOTS));
            foreach ($iterator as $key => $value) {
                $files->add($key, new FileItem($value, $this->dir));
            }
        }
        return $files;
    }
}