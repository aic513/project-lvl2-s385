<?php

namespace Differ\Parser;

function parse($content)
{
    return json_decode(file_get_contents($content), true);
}
