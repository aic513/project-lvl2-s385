<?php

namespace Differ\Render;

function render($result)
{
    return '{' . PHP_EOL . implode(PHP_EOL, $result) . PHP_EOL . '}';
}
