<?php

namespace App\GenDiff;

use function App\Parser\getType;
use function App\Parser\getData;
use function App\Parser\parse;
use function App\Ast\getAst;
use function App\Renderers\Render\render;

function genDiff($pathBefore, $pathAfter, $format)
{
    $before = parse(getType($pathBefore), getData($pathBefore));
    $after = parse(getType($pathAfter), getData($pathAfter));
    $ast = getAst($before, $after);
    return render($ast, $format);
}
