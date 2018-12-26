<?php
namespace Differ\Render;

function render($result)
{
    return '{' . PHP_EOL . implode("\n", $result) . PHP_EOL . '}';
}
