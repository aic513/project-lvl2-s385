<?php

namespace Differ\Render;

use function Funct\Collection\flattenAll;

function getSpace($level)
{
    return str_repeat(' ', $level * 4);
}

function innerRender($value, $level)
{
    if (!is_array($value)) {
        return $value;
    } else {
        $keys = array_keys($value);
        $arr = array_map(function ($item) use ($value, $level) {
            return [PHP_EOL . getSpace($level + 1) . "$item: $value[$item]"];
        }, $keys);
    }
    
    return implode("", flattenAll(array_merge(["{"], $arr, [PHP_EOL . getSpace($level) . "  }"])));
}

function render($item, $level)
{
    [
        'type' => $type,
        'key' => $key,
        'beforeValue' => $before,
        'afterValue' => $after,
        'children' => $children
    ] = $item;
    $before = innerRender($before, $level);
    $after = innerRender($after, $level);
    switch ($type) {
        case 'nested':
            return [
                getSpace($level) . "  $key: {",
                array_map(function ($item) use ($level) {
                    return render($item, $level + 1);
                }, $children),
                getSpace($level) . "  }"
            ];
        
        case 'unchanged':
            return [getSpace($level) . "  $key: $before"];
        
        case 'changed':
            return [getSpace($level) . "+ $key: $after" , getSpace($level) . "- $key: $before"];
        
        case 'deleted':
            return [getSpace($level) . "- $key: $before"];
        
        case 'added':
            return [getSpace($level) . "+ $key: $after"];
    }
}

function getPretty($ast)
{
    $result = array_map(function ($item) {
        return render($item, 0);
    }, $ast);
    
    return '{' . PHP_EOL . implode("\n", flattenAll($result)) . PHP_EOL . '}';
}
