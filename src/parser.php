<?php

namespace Differ\Parse;

use Symfony\Component\Yaml\Yaml;

function parse($type, $data)
{
    switch ($type) {
        case 'json':
            return json_decode($data, true);
            break;
        case 'yaml':
            return Yaml::parse($data);
            break;
        default:
            throw new \Exception("Unsupported content type {$type}".PHP_EOL);
    }
}

function getType($file)
{
    return pathinfo($file, PATHINFO_EXTENSION);
}

function getData($file)
{
    if(file_exists($file) && is_readable($file)) {
        $content = file_get_contents($file);
        if (empty($content)) {
            throw new \Exception("File {$file} is empty or has unsupported content");
        }
    
        return file_get_contents($file);
    }
    throw new \Exception("File '{$file}' is not exists");
}
