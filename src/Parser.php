<?php

namespace App\Parser;

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
            throw new \Exception("Unsupported content type '{$type}'");
    }
}

function getType($file)
{
    checkFileExists($file);
    
    return pathinfo($file, PATHINFO_EXTENSION);
}

function getData($file)
{
    checkFileExists($file);
    
    if (is_readable($file)) {
        $content = file_get_contents($file, true);
        if (empty($content)) {
            throw new \Exception("File {$file} is empty or has unsupported content");
        }
        
        return $content;
    }
    throw new \Exception('Permission denied for this file');
}

function checkFileExists($file)
{
    if (!file_exists($file)) {
        throw new \Exception("File '{$file}' is not exists");
    }
    
    return $file;
}
