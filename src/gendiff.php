<?php

namespace Differ\GenDiff;

use function Differ\Render\getPretty;
use function Differ\Parse\getType;
use function Differ\Parse\getData;
use function Differ\Parse\parse;
use function Differ\Ast\getAst;

function genDiff($pathBefore, $pathAfter)
{
    $before = parse(getType($pathBefore), getData($pathBefore));
    $after = parse(getType($pathAfter), getData($pathAfter));
    $ast = getAst($before, $after);
    return getPretty($ast);
}
