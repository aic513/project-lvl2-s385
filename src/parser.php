<?php

namespace Differ\Parse;

use Symfony\Component\Yaml\Yaml;

function parse($extension, $data)
{
    switch ($extension) {
        case 'json':
            return json_decode($data, true);
            break;
        case 'yaml':
            return Yaml::parse($data);
            break;
        default:
            return null;
            break;
    }
}

function getExtension($file)
{
    return pathinfo($file, PATHINFO_EXTENSION);
}

function getData($file)
{
    return file_get_contents($file);
}
