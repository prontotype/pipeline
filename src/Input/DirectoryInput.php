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

    public function name()
    {
        return 'files';
    }

    public function data()
    {
        if (!$this->files) {
            $files = new Collection();
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->dir, \FilesystemIterator::SKIP_DOTS));
            foreach ($iterator as $key => $value) {
                $item = new FileItem($value, $this->dir);
                $files->add($item['rel_pathname'], $item);
            }
        }
        return $files;
    }
}