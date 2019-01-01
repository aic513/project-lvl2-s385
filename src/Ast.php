<?php

namespace Differ\Ast;

function boolToStr($bool)
{
    return $bool ? 'true' : 'false';
}

function buildNodeStructure($type, $key, $beforeValue, $afterValue, $children)
{
    return
        [
            'type' => $type,
            'key' => $key,
            'beforeValue' => $beforeValue,
            'afterValue' => $afterValue,
            'children' => $children,
        ];
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
                $ast = buildNodeStructure('nested', $key, null, null, getAst($beforeValue, $afterValue));
            } elseif ($beforeValue === $afterValue) {
                $ast = buildNodeStructure('unchanged', $key, $beforeValue, $afterValue, null);
            } else {
                $ast = buildNodeStructure('changed', $key, $beforeValue, $afterValue, null);
            }
        }
        if (array_key_exists($key, $before) && !array_key_exists($key, $after)) {
            $ast = buildNodeStructure('deleted', $key, $beforeValue, null, null);
        }
        if (!array_key_exists($key, $before) && array_key_exists($key, $after)) {
            $ast = buildNodeStructure('added', $key, null, $afterValue, null);
        }
        
        return $ast;
    }, $keys);
}
