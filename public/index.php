<?php 

require __DIR__  . '/../vendor/autoload.php';

use Prontotype\Pipeline\Input\DirectoryInput;
use Prontotype\Pipeline\Output\DirectoryOutput;
use Prontotype\Pipeline\Output\DebugOutput;
use Prontotype\Pipeline\Pipe;
use Prontotype\Pipeline\Pipeline;

// $pipeline = new Pipeline(__DIR__ . '/files');
// $pipeline2 = new Pipeline(__DIR__ . '/files');

// $pipeline
//     ->pipe(new Pipe\YamlFrontMatterPipe())
//     // ->pipe(new Pipe\Filter\MetadataFilterPipe('status', 'draft|live'))
//     ->pipe(new Pipe\MarkdownParserPipe())
//     ->pipe(new Pipe\Template\MustacheParserPipe([
//         'title' => "this is the title",
//         'test' => 'hello'
//     ]));

// $pipeline2
//     ->pipe(new Pipe\YamlFrontMatterPipe())
//     ->pipe(new Pipe\Filter\ExtensionFilterPipe('scss'));

// $pipeline->merge($pipeline2)->output(new DirectoryOutput(__DIR__ . '/build'));

// foreach ($pipeline as $item) {
//     echo $item['rel_pathname'], '<br>', '<br>';
// }

// echo '<pre>';
// print_r('------------------');
// echo '</pre>';

$pipeline = new Pipeline(__DIR__ . '/files');
$pipeline
    ->pipe(new Pipe\ComponentCollectorPipe(['mustache']))
    ->pipe(new Pipe\Template\MustacheParserPipe())
    // ->output(new DebugOutput())
    ->output(new DirectoryOutput(__DIR__ . '/build'));

// echo '<pre>';
// print_r($pipeline);
// echo '</pre>';