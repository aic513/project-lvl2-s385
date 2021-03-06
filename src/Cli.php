<?php

namespace Differf\Cli;

use Docopt;
use function Differ\GenDiff\genDiff;

const DOC =
<<<DOC
Generate diff

Usage:
  gendiff (-h|--help)
  gendiff [--format <fmt>] <firstFile> <secondFile>

Options:
  -h --help                     Show this screen
  --format <fmt>                Report format [default: pretty]
DOC;

function run()
{
    $handle = Docopt::handle(DOC);
    $isFullPath = function ($path) {
        return $path[0] === DIRECTORY_SEPARATOR;
    };
    $firstFile = $handle->args['<firstFile>'];
    $secondFile = $handle->args['<secondFile>'];
    $format = $handle->args['--format'];
    $firstPath = $isFullPath($firstFile) ? $firstFile : \getcwd() . DIRECTORY_SEPARATOR . $firstFile;
    $secondPath = $isFullPath($secondFile) ? $secondFile : \getcwd() . DIRECTORY_SEPARATOR . $secondFile;
    
    try {
        echo genDiff($firstPath, $secondPath, $format);
    } catch (\Exception $exception) {
        echo $exception->getMessage() . PHP_EOL;
    }
}
