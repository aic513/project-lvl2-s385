<?php

namespace Differ\GenDiff;

use function Differ\Parser\getType;
use function Differ\Parser\getData;
use function Differ\Parser\parse;
use function Differ\Ast\getAst;
use function Differ\Renderers\Render\render;

function genDiff($pathBefore, $pathAfter, $format)
{
    $before = parse(getType($pathBefore), getData($pathBefore));
    $after = parse(getType($pathAfter), getData($pathAfter));
    $ast = getAst($before, $after);
    return render($ast, $format);
}
