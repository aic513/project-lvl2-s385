<?php

namespace Differ\Ast;

function boolToStr($bool)
{
    return $bool ? 'true' : 'false';
}
function getAst($before, $after)
{
    $keys = array_unique(array_merge(array_keys($before), array_keys($after)));
    return array_map(function ($key) use ($before, $after) {
        $valueBefore = $before[$key] ?? '';
        $valueAfter = $after[$key] ?? '';
        $beforeValue = is_bool($valueBefore) ? boolToStr($valueBefore) : $valueBefore;
        $afterValue = is_bool($valueAfter) ? boolToStr($valueAfter) : $valueAfter;
        
        if (array_key_exists($key, $before) && array_key_exists($key, $after)) {
            if (is_array($beforeValue) && is_array($afterValue)) {
                $nodes = [
                    'type' => 'nested',
                    'key' => $key,
                    'beforeValue' => null,
                    'afterValue' => null,
                    'children' => getAst($beforeValue, $afterValue)
                ];
            } elseif ($beforeValue === $afterValue) {
                $nodes = [
                    'type' => 'unchanged',
                    'key' => $key,
                    'beforeValue' => $beforeValue,
                    'afterValue' => $afterValue,
                    'children' => null
                ];
            } else {
                $nodes = [
                    'type' => 'changed',
                    'key' => $key,
                    'beforeValue' => $beforeValue,
                    'afterValue' => $afterValue,
                    'children' => null
                ];
            }
        }
        if (array_key_exists($key, $before) && !array_key_exists($key, $after)) {
            $nodes = [
                'type' => 'deleted',
                'key' => $key,
                'beforeValue' => $beforeValue,
                'afterValue' => null,
                'children' => null
            ];
        }
        if (!array_key_exists($key, $before) && array_key_exists($key, $after)) {
            $nodes = [
                'type' => 'added',
                'key' => $key,
                'beforeValue' => null,
                'afterValue' => $afterValue,
                'children' => null
            ];
        }
        return $nodes;
    }, $keys);
}
