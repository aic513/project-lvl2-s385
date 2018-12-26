<?php

namespace Differ\GenDiff;

use function Differ\Parser\parse;
use function Differ\Render\render;

function convertBooleanToString($bool)
{
    return $bool ? 'true' : 'false';
}

function genDiff($file1, $file2)
{
    $fileBefore = parse($file1);
    $fileAfter = parse($file2);
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
