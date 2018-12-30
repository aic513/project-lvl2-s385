<?php

namespace Differ\GenDiff;

use function Differ\Parse\getType;
use function Differ\Parse\getData;
use function Differ\Parse\parse;
use function Differ\Ast\getAst;
use function Differ\Render\render;

function genDiff($pathBefore, $pathAfter, $format)
{
    $before = parse(getType($pathBefore), getData($pathBefore));
    $after = parse(getType($pathAfter), getData($pathAfter));
    $ast = getAst($before, $after);
    return render($ast, $format);
}
