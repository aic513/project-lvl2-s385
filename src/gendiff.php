<?php

namespace Differ\GenDiff;

use function Differ\Render\render;
use function Differ\Parse\getExtension;
use function Differ\Parse\getData;
use function Differ\Parse\parse;

function convertBooleanToString($bool)
{
    return $bool ? 'true' : 'false';
}

function genDiff($file1, $file2)
{
    $fileBeforeExtension = getExtension($file1);
    $fileAfterExtension = getExtension($file2);
    
    $fileBeforeData = getData($file1);
    $fileAfterData = getData($file2);
    
    $fileBefore = parse($fileBeforeExtension, $fileBeforeData);
    $fileAfter = parse($fileAfterExtension, $fileAfterData);
    
    $keys = array_unique(array_merge(array_keys($fileBefore), array_keys($fileAfter)));
    $result = array_reduce($keys, function ($acc, $key) use ($fileBefore, $fileAfter) {
        
        if (array_key_exists($key, $fileBefore) && array_key_exists($key, $fileAfter)) {
            $beforeValue = is_bool($fileBefore[$key]) ? convertBooleanToString($fileBefore[$key]) : $fileBefore[$key];
            $afterValue = is_bool($fileAfter[$key]) ? convertBooleanToString($fileAfter[$key]) : $fileAfter[$key];
            if ($beforeValue === $afterValue) {
                return array_merge($acc, ["  $key: $beforeValue"]);
            } else {
                return array_merge($acc, ["+ $key: $afterValue"], ["- $key: $beforeValue"]);
            }
        }
        
        if (array_key_exists($key, $fileBefore) && !array_key_exists($key, $fileAfter)) {
            $beforeValue = is_bool($fileBefore[$key]) ? convertBooleanToString($fileBefore[$key]) : $fileBefore[$key];
            
            return array_merge($acc, ["- $key: $beforeValue"]);
        }
        
        if (!array_key_exists($key, $fileBefore) && array_key_exists($key, $fileAfter)) {
            $afterValue = is_bool($fileAfter[$key]) ? convertBooleanToString($fileAfter[$key]) : $fileAfter[$key];
            
            return array_merge($acc, ["+ $key: $afterValue"]);
        }
        
        return $acc;
    }, []);
    
    return render($result);
}
