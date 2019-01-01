<?php

namespace Differ\Renderers\Pretty;

use function Funct\Collection\flattenAll;

function pretty($ast)
{
    $arr = array_map(function ($item) {
        return getPretty($item, 0);
    }, $ast);
    
    return '{' . PHP_EOL . implode("\n", array_filter(flattenAll($arr))) . PHP_EOL . '}';
}

function getPretty($item, $level)
{
    [
        'type' => $type,
        'key' => $key,
        'beforeValue' => $before,
        'afterValue' => $after,
        'children' => $children
    ] = $item;
    $before = prettyInner($before, $level);
    $after = prettyInner($after, $level);
    switch ($type) {
        case 'nested':
            return [
                getSpace($level) . "  $key: {",
                array_map(function ($item) use ($level) {
                    return getPretty($item, $level + 1);
                }, $children),
                getSpace($level) . "  }"
            ];
        
        case 'unchanged':
            return getSpace($level) . "  $key: $before";
        
        case 'changed':
            return [getSpace($level) . "+ $key: $after", getSpace($level) . "- $key: $before"];
        
        case 'deleted':
            return getSpace($level) . "- $key: $before";
        
        case 'added':
            return getSpace($level) . "+ $key: $after";
    }
}

function getSpace($level)
{
    return str_repeat(' ', $level * 4);
}

function prettyInner($value, $level)
{
    if (!is_array($value)) {
        return $value;
    }
    $keys = array_keys($value);
    $result = array_map(function ($item) use ($value, $level) {
        return [PHP_EOL . getSpace($level + 1) . "$item: $value[$item]"];
    }, $keys);
    
    return implode("", flattenAll(array_merge(["{"], $result, [PHP_EOL . getSpace($level) . "  }"])));
}
