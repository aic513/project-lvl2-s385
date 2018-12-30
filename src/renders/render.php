<?php

namespace Differ\Render;

use function Differ\Pretty\pretty;
use function Differ\Plain\plain;

function render($ast, $format)
{
    switch ($format) {
        case 'pretty':
            return pretty($ast);
            break;
        case 'plain':
            return plain($ast);
            break;
        default:
            throw new \Exception("Format '{$format}' is unsupported in this app" . PHP_EOL);
    }
}
